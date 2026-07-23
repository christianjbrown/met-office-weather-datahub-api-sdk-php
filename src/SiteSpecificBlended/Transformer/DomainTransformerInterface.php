<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\DomainInterface;

interface DomainTransformerInterface
{
    public const string KEY_AXES = 'axes';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DomainInterface;
}
