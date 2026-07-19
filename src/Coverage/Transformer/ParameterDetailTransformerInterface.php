<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\ParameterDetailInterface;

interface ParameterDetailTransformerInterface
{
    public const KEY_EXTENT = 'extent';
    public const KEY_PARAMETER_ID = 'parameterId';
    public const KEY_TIME = 't';
    public const KEY_VERTICAL = 'z';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterDetailInterface;
}
