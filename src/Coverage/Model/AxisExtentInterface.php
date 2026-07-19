<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Model;

interface AxisExtentInterface
{
    public function getLabel(): ?string;

    public function getLowerBound(): ?string;

    public function getUomLabel(): ?string;

    public function getUpperBound(): ?string;

    public function setLabel(?string $value): self;

    public function setLowerBound(?string $value): self;

    public function setUomLabel(?string $value): self;

    public function setUpperBound(?string $value): self;
}
