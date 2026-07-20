<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\ParameterDetailInterface;

interface ParameterDetailTransformerInterface
{
    public const string KEY_EXTENT = 'extent';
    public const string KEY_PARAMETER_ID = 'parameterId';
    public const string KEY_TIME = 't';
    public const string KEY_VERTICAL = 'z';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterDetailInterface;
}
