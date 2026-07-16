<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Model;

interface ForecastTimeStepInterface
{
    public function getTime(): int;
}
