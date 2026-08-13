<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Axis;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxisTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Axis::class)]
#[CoversClass(AxisTransformer::class)]
final class AxisTransformerTest extends TestCase
{
    public function testTransformNumericAxis(): void
    {
        $data = [
            AxisTransformerInterface::KEY_NAME => 'x',
            AxisTransformerInterface::KEY_VALUES => [50.1643, 145, 'not-a-number'],
        ];

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame('x', $axis->getName());
        self::assertSame([], $axis->getBounds());
        self::assertSame([50.1643, 145.0], $axis->getFloatValues());
        self::assertSame(['not-a-number'], $axis->getStringValues());
    }

    public function testTransformPeriodAxisWithBounds(): void
    {
        $data = [
            AxisTransformerInterface::KEY_NAME => 't',
            AxisTransformerInterface::KEY_VALUES => ['2026-08-13T00:00:00Z'],
            AxisTransformerInterface::KEY_BOUNDS => ['2026-08-12T12:00:00Z', '2026-08-13T00:00:00Z', 42],
        ];

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame(['2026-08-12T12:00:00Z', '2026-08-13T00:00:00Z'], $axis->getBounds());
        self::assertSame(['2026-08-13T00:00:00Z'], $axis->getStringValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsValuesCases')]
    public function testTransformSkipsValues(array $data): void
    {
        $data[AxisTransformerInterface::KEY_NAME] = 'x';

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame([], $axis->getBounds());
        self::assertSame([], $axis->getFloatValues());
        self::assertSame([], $axis->getStringValues());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsValuesCases(): iterable
    {
        yield 'valuesAbsent' => [[]];
        yield 'valuesWrongType' => [
            [
                AxisTransformerInterface::KEY_BOUNDS => 'not-an-array',
                AxisTransformerInterface::KEY_VALUES => 'not-an-array',
            ],
        ];
    }

    public function testTransformStringAxis(): void
    {
        $data = [
            AxisTransformerInterface::KEY_NAME => 't',
            AxisTransformerInterface::KEY_VALUES => ['2024-03-08T00:00:00Z', '2024-03-08T01:00:00Z', 42],
        ];

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame('t', $axis->getName());
        self::assertSame([], $axis->getBounds());
        self::assertSame(['2024-03-08T00:00:00Z', '2024-03-08T01:00:00Z'], $axis->getStringValues());
        // Any stray numeric value is partitioned into floatValues.
        self::assertSame([42.0], $axis->getFloatValues());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[AxisTransformerInterface::KEY_NAME => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AxisTransformerInterface::UNEXPECTED_STRING_SPRINTF, AxisTransformerInterface::KEY_NAME));

        (new AxisTransformer())->transform($data);
    }
}
