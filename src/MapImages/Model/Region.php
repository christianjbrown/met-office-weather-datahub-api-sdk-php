<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

final class Region implements RegionInterface
{
    private ?string $name = null;
    private ?AxisExtentInterface $x = null;
    private ?AxisExtentInterface $y = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getX(): ?AxisExtentInterface
    {
        return $this->x;
    }

    public function getY(): ?AxisExtentInterface
    {
        return $this->y;
    }

    public function setName(?string $value): RegionInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setX(?AxisExtentInterface $value): RegionInterface
    {
        $this->x = $value;

        return $this;
    }

    public function setY(?AxisExtentInterface $value): RegionInterface
    {
        $this->y = $value;

        return $this;
    }
}
