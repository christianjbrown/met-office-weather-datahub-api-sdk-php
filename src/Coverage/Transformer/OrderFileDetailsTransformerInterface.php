<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetailsInterface;

interface OrderFileDetailsTransformerInterface
{
    public const string KEY_FILE = 'file';
    public const string KEY_PARAMETER_DETAILS = 'parameterDetails';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileDetailsInterface;
}
