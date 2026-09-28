<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadataInterface;

interface ParameterMetadataTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LABEL = 'label';
    public const string KEY_SYMBOL = 'symbol';
    public const string KEY_TYPE = 'type';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterMetadataInterface;
}
