<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface DomainInterface
{
    /**
     * @return array<string, AxisInterface>
     */
    public function getAxes(): array;

    /**
     * @param array<string, AxisInterface> $value
     */
    public function setAxes(array $value): self;
}
