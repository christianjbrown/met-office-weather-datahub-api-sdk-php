<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

final class AxisExtent implements AxisExtentInterface
{
    private ?string $label = null;
    private ?string $lowerBound = null;
    private ?string $uomLabel = null;
    private ?string $upperBound = null;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLowerBound(): ?string
    {
        return $this->lowerBound;
    }

    public function getUomLabel(): ?string
    {
        return $this->uomLabel;
    }

    public function getUpperBound(): ?string
    {
        return $this->upperBound;
    }

    public function setLabel(?string $value): AxisExtentInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setLowerBound(?string $value): AxisExtentInterface
    {
        $this->lowerBound = $value;

        return $this;
    }

    public function setUomLabel(?string $value): AxisExtentInterface
    {
        $this->uomLabel = $value;

        return $this;
    }

    public function setUpperBound(?string $value): AxisExtentInterface
    {
        $this->upperBound = $value;

        return $this;
    }
}
