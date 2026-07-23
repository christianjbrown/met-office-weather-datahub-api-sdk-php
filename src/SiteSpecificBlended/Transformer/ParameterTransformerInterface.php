<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;

interface ParameterTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_EN = 'en';
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';
    public const string KEY_OBSERVED_PROPERTY = 'observedProperty';
    public const string KEY_SYMBOL = 'symbol';
    public const string KEY_UNIT = 'unit';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterInterface;
}
