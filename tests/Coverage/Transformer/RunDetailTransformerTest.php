<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RunDetail;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RunDetail::class)]
#[CoversClass(RunDetailTransformer::class)]
final class RunDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RunDetailTransformerInterface::KEY_RUN_DATE_TIME => '2021-01-25T06:00:00.000Z',
            RunDetailTransformerInterface::KEY_RUN => '06',
            RunDetailTransformerInterface::KEY_RUN_FILTER => '2021012506',
        ];

        $transformer = new RunDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1611554400, $actual->getRunDateTime());
        self::assertSame('06', $actual->getRun());
        self::assertSame('2021012506', $actual->getRunFilter());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            RunDetailTransformerInterface::KEY_RUN_DATE_TIME => '2021-01-25T06:00:00.000Z',
        ];

        $transformer = new RunDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1611554400, $actual->getRunDateTime());
        self::assertNull($actual->getRun());
        self::assertNull($actual->getRunFilter());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            RunDetailTransformerInterface::KEY_RUN_DATE_TIME => '2021-01-25T06:00:00.000Z',
            RunDetailTransformerInterface::KEY_RUN => 42,
            RunDetailTransformerInterface::KEY_RUN_FILTER => 42,
        ];

        $transformer = new RunDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getRun());
        self::assertNull($actual->getRunFilter());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], RunDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, RunDetailTransformerInterface::KEY_RUN_DATE_TIME])]
    #[TestWith([[RunDetailTransformerInterface::KEY_RUN_DATE_TIME => 42], RunDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, RunDetailTransformerInterface::KEY_RUN_DATE_TIME])]
    #[TestWith([[RunDetailTransformerInterface::KEY_RUN_DATE_TIME => 'test-not-a-timestamp'], RunDetailTransformerInterface::UNEXPECTED_TIMESTAMP_SPRINTF, 'test-not-a-timestamp'])]
    public function testTransformUnexpectedData(array $data, string $message, string $field): void
    {
        $transformer = new RunDetailTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($message, $field));
        $transformer->transform($data);
    }
}
