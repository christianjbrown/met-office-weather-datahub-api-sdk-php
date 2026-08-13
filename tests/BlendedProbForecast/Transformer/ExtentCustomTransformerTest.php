<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustom;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExtentCustom::class)]
#[CoversClass(ExtentCustomTransformer::class)]
final class ExtentCustomTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ExtentCustomTransformerInterface::KEY_ID => 'percentile',
            ExtentCustomTransformerInterface::KEY_INTERVAL => [['5', '95']],
            ExtentCustomTransformerInterface::KEY_REFERENCE => 'percentile',
            ExtentCustomTransformerInterface::KEY_VALUES => ['5', '50', 42],
        ];

        $extentCustom = (new ExtentCustomTransformer())->transform($data);

        self::assertSame('percentile', $extentCustom->getId());
        self::assertSame(['5', '95'], $extentCustom->getInterval());
        self::assertSame('percentile', $extentCustom->getReference());
        self::assertSame(['5', '50'], $extentCustom->getValues());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            ExtentCustomTransformerInterface::KEY_ID => 'percentile',
        ];

        $extentCustom = (new ExtentCustomTransformer())->transform($data);

        self::assertSame('percentile', $extentCustom->getId());
        self::assertSame([], $extentCustom->getInterval());
        self::assertNull($extentCustom->getReference());
        self::assertSame([], $extentCustom->getValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $extentCustom = (new ExtentCustomTransformer())->transform($data);

        self::assertSame([], $extentCustom->getInterval());
        self::assertNull($extentCustom->getReference());
        self::assertSame([], $extentCustom->getValues());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                ExtentCustomTransformerInterface::KEY_ID => 'percentile',
                ExtentCustomTransformerInterface::KEY_INTERVAL => 42,
                ExtentCustomTransformerInterface::KEY_REFERENCE => 42,
                ExtentCustomTransformerInterface::KEY_VALUES => 42,
            ],
        ];
        yield 'intervalEmpty' => [
            [
                ExtentCustomTransformerInterface::KEY_ID => 'percentile',
                ExtentCustomTransformerInterface::KEY_INTERVAL => [],
            ],
        ];
        yield 'intervalWrongFirst' => [
            [
                ExtentCustomTransformerInterface::KEY_ID => 'percentile',
                ExtentCustomTransformerInterface::KEY_INTERVAL => [42],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[TestWith([[]])]
    #[TestWith([[ExtentCustomTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ExtentCustomTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ExtentCustomTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExtentCustomTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
