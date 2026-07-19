<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFile;
use ChristianBrown\MetOffice\Coverage\Model\RegionInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderFile::class)]
#[CoversClass(OrderFileTransformer::class)]
final class OrderFileTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $regionData = ['test-region'];
        $data = [
            OrderFileTransformerInterface::KEY_FILE_ID => 'isbl_temperature_100000_+00',
            OrderFileTransformerInterface::KEY_SURFACE_ID => 'isbl',
            OrderFileTransformerInterface::KEY_RUN => '12',
            OrderFileTransformerInterface::KEY_RUN_DATE_TIME => '2020-02-19T12:00:00.000Z',
            OrderFileTransformerInterface::KEY_REGION => $regionData,
            OrderFileTransformerInterface::KEY_LEVELS => ['100000', 42],
            OrderFileTransformerInterface::KEY_PARAMETERS => ['temperature', 42],
            OrderFileTransformerInterface::KEY_TIMESTEPS => ['0', '3', 42],
        ];

        $region = self::createStub(RegionInterface::class);

        $regionTransformer = self::createMock(RegionTransformerInterface::class);
        $regionTransformer->method('transform')
            ->with($regionData)
            ->willReturn($region);

        $transformer = new OrderFileTransformer($regionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('isbl_temperature_100000_+00', $actual->getFileId());
        self::assertSame('isbl', $actual->getSurfaceId());
        self::assertSame('12', $actual->getRun());
        self::assertSame(1582113600, $actual->getRunDateTime());
        self::assertSame($region, $actual->getRegion());
        self::assertSame(['100000'], $actual->getLevels());
        self::assertSame(['temperature'], $actual->getParameters());
        self::assertSame(['0', '3'], $actual->getTimesteps());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            OrderFileTransformerInterface::KEY_FILE_ID => 'isbl_temperature_100000_+00',
        ];

        $regionTransformer = self::createMock(RegionTransformerInterface::class);
        $regionTransformer->expects(self::never())->method('transform');

        $transformer = new OrderFileTransformer($regionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('isbl_temperature_100000_+00', $actual->getFileId());
        self::assertNull($actual->getSurfaceId());
        self::assertNull($actual->getRun());
        self::assertNull($actual->getRunDateTime());
        self::assertNull($actual->getRegion());
        self::assertSame([], $actual->getLevels());
        self::assertSame([], $actual->getParameters());
        self::assertSame([], $actual->getTimesteps());
    }

    public function testTransformSkipsInvalidRunDateTime(): void
    {
        $data = [
            OrderFileTransformerInterface::KEY_FILE_ID => 'isbl_temperature_100000_+00',
            OrderFileTransformerInterface::KEY_RUN_DATE_TIME => 'not-a-timestamp',
        ];

        $regionTransformer = self::createStub(RegionTransformerInterface::class);

        $transformer = new OrderFileTransformer($regionTransformer);

        self::assertNull($transformer->transform($data)->getRunDateTime());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            OrderFileTransformerInterface::KEY_FILE_ID => 'isbl_temperature_100000_+00',
            OrderFileTransformerInterface::KEY_SURFACE_ID => 42,
            OrderFileTransformerInterface::KEY_RUN => 42,
            OrderFileTransformerInterface::KEY_RUN_DATE_TIME => 42,
            OrderFileTransformerInterface::KEY_REGION => 'not-an-array',
            OrderFileTransformerInterface::KEY_LEVELS => 'not-an-array',
            OrderFileTransformerInterface::KEY_PARAMETERS => 'not-an-array',
            OrderFileTransformerInterface::KEY_TIMESTEPS => 'not-an-array',
        ];

        $regionTransformer = self::createMock(RegionTransformerInterface::class);
        $regionTransformer->expects(self::never())->method('transform');

        $transformer = new OrderFileTransformer($regionTransformer);

        $actual = $transformer->transform($data);

        self::assertNull($actual->getSurfaceId());
        self::assertNull($actual->getRun());
        self::assertNull($actual->getRunDateTime());
        self::assertNull($actual->getRegion());
        self::assertSame([], $actual->getLevels());
        self::assertSame([], $actual->getParameters());
        self::assertSame([], $actual->getTimesteps());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[OrderFileTransformerInterface::KEY_FILE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $regionTransformer = self::createStub(RegionTransformerInterface::class);

        $transformer = new OrderFileTransformer($regionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrderFileTransformerInterface::UNEXPECTED_STRING_SPRINTF, OrderFileTransformerInterface::KEY_FILE_ID));
        $transformer->transform($data);
    }
}
