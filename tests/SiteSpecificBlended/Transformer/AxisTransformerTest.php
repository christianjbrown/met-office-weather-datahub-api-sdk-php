<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Axis;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxisTransformerInterface;
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
        self::assertSame([50.1643, 145.0], $axis->getFloatValues());
        self::assertSame(['not-a-number'], $axis->getStringValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsValuesCases')]
    public function testTransformSkipsValues(array $data): void
    {
        $data[AxisTransformerInterface::KEY_NAME] = 'x';

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame([], $axis->getFloatValues());
        self::assertSame([], $axis->getStringValues());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsValuesCases(): iterable
    {
        yield 'valuesAbsent' => [[]];
        yield 'valuesWrongType' => [[AxisTransformerInterface::KEY_VALUES => 'not-an-array']];
    }

    public function testTransformStringAxis(): void
    {
        $data = [
            AxisTransformerInterface::KEY_NAME => 't',
            AxisTransformerInterface::KEY_VALUES => ['2024-03-08T00:00:00Z', '2024-03-08T01:00:00Z', 42],
        ];

        $axis = (new AxisTransformer())->transform($data);

        self::assertSame('t', $axis->getName());
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
