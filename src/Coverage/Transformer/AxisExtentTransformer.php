<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\AxisExtent;
use ChristianBrown\MetOffice\Coverage\Model\AxisExtentInterface;

use function is_string;

final class AxisExtentTransformer implements AxisExtentTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AxisExtentInterface
    {
        $axisExtent = new AxisExtent();

        $this->applyLabel($axisExtent, $data);
        $this->applyLowerBound($axisExtent, $data);
        $this->applyUomLabel($axisExtent, $data);
        $this->applyUpperBound($axisExtent, $data);

        return $axisExtent;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLabel(AxisExtent $axisExtent, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $axisExtent->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLowerBound(AxisExtent $axisExtent, array $data): void
    {
        if (empty($data[self::KEY_LOWER_BOUND])) {
            return;
        }
        if (!is_string($data[self::KEY_LOWER_BOUND])) {
            return;
        }
        $axisExtent->setLowerBound($data[self::KEY_LOWER_BOUND]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUomLabel(AxisExtent $axisExtent, array $data): void
    {
        if (empty($data[self::KEY_UOM_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_UOM_LABEL])) {
            return;
        }
        $axisExtent->setUomLabel($data[self::KEY_UOM_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUpperBound(AxisExtent $axisExtent, array $data): void
    {
        if (empty($data[self::KEY_UPPER_BOUND])) {
            return;
        }
        if (!is_string($data[self::KEY_UPPER_BOUND])) {
            return;
        }
        $axisExtent->setUpperBound($data[self::KEY_UPPER_BOUND]);
    }
}
