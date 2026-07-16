<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

interface RegionInterface
{
    public function getName(): ?string;

    public function getX(): ?AxisExtentInterface;

    public function getY(): ?AxisExtentInterface;

    public function setName(?string $value): self;

    public function setX(?AxisExtentInterface $value): self;

    public function setY(?AxisExtentInterface $value): self;
}
