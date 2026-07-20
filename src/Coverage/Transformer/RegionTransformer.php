<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\Region;
use ChristianBrown\MetOffice\Coverage\Model\RegionInterface;

use function is_array;
use function is_string;

final class RegionTransformer implements RegionTransformerInterface
{
    private AxisExtentTransformerInterface $axisExtentTransformer;

    public function __construct(AxisExtentTransformerInterface $axisExtentTransformer)
    {
        $this->axisExtentTransformer = $axisExtentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RegionInterface
    {
        $region = new Region();

        $this->applyName($region, $data);
        $this->applyX($region, $data);
        $this->applyY($region, $data);

        return $region;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyName(Region $region, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $region->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyX(Region $region, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $extent = $data[self::KEY_EXTENT];
        if (!isset($extent[self::KEY_X])) {
            return;
        }
        if (!is_array($extent[self::KEY_X])) {
            return;
        }
        $region->setX($this->axisExtentTransformer->transform($extent[self::KEY_X]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyY(Region $region, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $extent = $data[self::KEY_EXTENT];
        if (!isset($extent[self::KEY_Y])) {
            return;
        }
        if (!is_array($extent[self::KEY_Y])) {
            return;
        }
        $region->setY($this->axisExtentTransformer->transform($extent[self::KEY_Y]));
    }
}
