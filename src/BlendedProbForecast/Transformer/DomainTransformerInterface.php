<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\DomainInterface;

interface DomainTransformerInterface
{
    public const string KEY_AXES = 'axes';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DomainInterface;
}
