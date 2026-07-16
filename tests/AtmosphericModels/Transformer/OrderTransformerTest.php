<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\Order;
use ChristianBrown\MetOffice\AtmosphericModels\Model\RegionInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RegionsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Order::class)]
#[CoversClass(OrderTransformer::class)]
final class OrderTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $regionsData = [['test-region-1']];
        $data = [
            OrderTransformerInterface::KEY_ORDER_ID => 'myorder',
            OrderTransformerInterface::KEY_NAME => 'my_order',
            OrderTransformerInterface::KEY_MODEL_ID => 'mo-global',
            OrderTransformerInterface::KEY_FORMAT => 'GRIB2',
            OrderTransformerInterface::KEY_DESCRIPTION => 'Example order',
            OrderTransformerInterface::KEY_REGIONS => $regionsData,
            OrderTransformerInterface::KEY_REQUIRED_LATEST_RUNS => ['00', 42],
            OrderTransformerInterface::KEY_TIMESTEPS => ['0', '3', 42],
        ];

        $region = self::createStub(RegionInterface::class);
        $regions = [$region];

        $regionsTransformer = self::createMock(RegionsTransformerInterface::class);
        $regionsTransformer->method('transform')
            ->with($regionsData)
            ->willReturn($regions);

        $transformer = new OrderTransformer($regionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('myorder', $actual->getOrderId());
        self::assertSame('my_order', $actual->getName());
        self::assertSame('mo-global', $actual->getModelId());
        self::assertSame('GRIB2', $actual->getFormat());
        self::assertSame('Example order', $actual->getDescription());
        self::assertSame($regions, $actual->getRegions());
        self::assertSame(['00'], $actual->getRequiredLatestRuns());
        self::assertSame(['0', '3'], $actual->getTimesteps());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            OrderTransformerInterface::KEY_ORDER_ID => 'myorder',
        ];

        $regionsTransformer = self::createMock(RegionsTransformerInterface::class);
        $regionsTransformer->expects(self::never())->method('transform');

        $transformer = new OrderTransformer($regionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('myorder', $actual->getOrderId());
        self::assertNull($actual->getName());
        self::assertNull($actual->getModelId());
        self::assertNull($actual->getFormat());
        self::assertNull($actual->getDescription());
        self::assertSame([], $actual->getRegions());
        self::assertSame([], $actual->getRequiredLatestRuns());
        self::assertSame([], $actual->getTimesteps());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            OrderTransformerInterface::KEY_ORDER_ID => 'myorder',
            OrderTransformerInterface::KEY_NAME => 42,
            OrderTransformerInterface::KEY_MODEL_ID => 42,
            OrderTransformerInterface::KEY_FORMAT => 42,
            OrderTransformerInterface::KEY_DESCRIPTION => 42,
            OrderTransformerInterface::KEY_REGIONS => 'not-an-array',
            OrderTransformerInterface::KEY_REQUIRED_LATEST_RUNS => 'not-an-array',
            OrderTransformerInterface::KEY_TIMESTEPS => 'not-an-array',
        ];

        $regionsTransformer = self::createMock(RegionsTransformerInterface::class);
        $regionsTransformer->expects(self::never())->method('transform');

        $transformer = new OrderTransformer($regionsTransformer);

        $actual = $transformer->transform($data);

        self::assertNull($actual->getName());
        self::assertNull($actual->getModelId());
        self::assertNull($actual->getFormat());
        self::assertNull($actual->getDescription());
        self::assertSame([], $actual->getRegions());
        self::assertSame([], $actual->getRequiredLatestRuns());
        self::assertSame([], $actual->getTimesteps());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], OrderTransformerInterface::KEY_ORDER_ID])]
    #[TestWith([[OrderTransformerInterface::KEY_ORDER_ID => 42], OrderTransformerInterface::KEY_ORDER_ID])]
    public function testTransformUnexpectedData(array $data, string $field): void
    {
        $regionsTransformer = self::createStub(RegionsTransformerInterface::class);

        $transformer = new OrderTransformer($regionsTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrderTransformerInterface::UNEXPECTED_STRING_SPRINTF, $field));
        $transformer->transform($data);
    }
}
