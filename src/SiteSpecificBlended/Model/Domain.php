<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Domain implements DomainInterface
{
    /**
     * @var array<string, AxisInterface>
     */
    private array $axes = [];

    /**
     * @return array<string, AxisInterface>
     */
    public function getAxes(): array
    {
        return $this->axes;
    }

    /**
     * @param array<string, AxisInterface> $value
     */
    public function setAxes(array $value): DomainInterface
    {
        $this->axes = $value;

        return $this;
    }
}
