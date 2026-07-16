<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\OrderFileInterface;

interface OrderFilesTransformerInterface
{
    public const ARRAY_NAME = 'files';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderFileInterface>
     */
    public function transform(array $data): array;
}
