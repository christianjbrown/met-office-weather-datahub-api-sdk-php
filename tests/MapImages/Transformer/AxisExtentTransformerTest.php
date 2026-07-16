<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\AxisExtent;
use ChristianBrown\MetOffice\MapImages\Transformer\AxisExtentTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\AxisExtentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AxisExtent::class)]
#[CoversClass(AxisExtentTransformer::class)]
final class AxisExtentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AxisExtentTransformerInterface::KEY_LABEL => 'longitude',
            AxisExtentTransformerInterface::KEY_LOWER_BOUND => '-14.0000',
            AxisExtentTransformerInterface::KEY_UOM_LABEL => 'degree',
            AxisExtentTransformerInterface::KEY_UPPER_BOUND => '37.0000',
        ];

        $transformer = new AxisExtentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('longitude', $actual->getLabel());
        self::assertSame('-14.0000', $actual->getLowerBound());
        self::assertSame('degree', $actual->getUomLabel());
        self::assertSame('37.0000', $actual->getUpperBound());
    }

    public function testTransformMinimal(): void
    {
        $transformer = new AxisExtentTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getLowerBound());
        self::assertNull($actual->getUomLabel());
        self::assertNull($actual->getUpperBound());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            AxisExtentTransformerInterface::KEY_LABEL => 42,
            AxisExtentTransformerInterface::KEY_LOWER_BOUND => 42,
            AxisExtentTransformerInterface::KEY_UOM_LABEL => 42,
            AxisExtentTransformerInterface::KEY_UPPER_BOUND => 42,
        ];

        $transformer = new AxisExtentTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getLowerBound());
        self::assertNull($actual->getUomLabel());
        self::assertNull($actual->getUpperBound());
    }
}
