<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Model\ForecastTimeStepInterface;

interface ForecastTimeStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ForecastTimeStepInterface;
}
