<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArray;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangeTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NdArray::class)]
#[CoversClass(RangeTransformer::class)]
final class RangeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RangeTransformerInterface::KEY_ID => 'feels_like_temperature',
            RangeTransformerInterface::KEY_AXIS_NAMES => ['t', 42],
            RangeTransformerInterface::KEY_DATA_TYPE => 'float',
            RangeTransformerInterface::KEY_SHAPE => [48, 'x'],
            RangeTransformerInterface::KEY_VALUES => [12.3, null, 13, 'x'],
        ];

        $ndArray = (new RangeTransformer())->transform($data);

        self::assertSame('feels_like_temperature', $ndArray->getId());
        self::assertSame(['t'], $ndArray->getAxisNames());
        self::assertSame('float', $ndArray->getDataType());
        self::assertSame([48], $ndArray->getShape());
        self::assertSame([12.3, null, 13.0, null], $ndArray->getValues());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            RangeTransformerInterface::KEY_ID => 'feels_like_temperature',
        ];

        $ndArray = (new RangeTransformer())->transform($data);

        self::assertSame([], $ndArray->getAxisNames());
        self::assertNull($ndArray->getDataType());
        self::assertSame([], $ndArray->getShape());
        self::assertSame([], $ndArray->getValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $data[RangeTransformerInterface::KEY_ID] = 'feels_like_temperature';

        $ndArray = (new RangeTransformer())->transform($data);

        self::assertSame([], $ndArray->getAxisNames());
        self::assertNull($ndArray->getDataType());
        self::assertSame([], $ndArray->getShape());
        self::assertSame([], $ndArray->getValues());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                RangeTransformerInterface::KEY_AXIS_NAMES => 'not-an-array',
                RangeTransformerInterface::KEY_DATA_TYPE => 42,
                RangeTransformerInterface::KEY_SHAPE => 'not-an-array',
                RangeTransformerInterface::KEY_VALUES => 'not-an-array',
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[RangeTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RangeTransformerInterface::UNEXPECTED_STRING_SPRINTF, RangeTransformerInterface::KEY_ID));

        (new RangeTransformer())->transform($data);
    }
}
