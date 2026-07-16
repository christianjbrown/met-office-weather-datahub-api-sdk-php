<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

interface ForecastTimeStepInterface
{
    public function getTime(): int;
}
