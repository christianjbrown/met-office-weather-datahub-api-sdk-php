<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;

interface ForecastTimeStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ForecastTimeStepInterface;
}
