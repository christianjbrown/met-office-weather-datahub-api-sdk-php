<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\OrderInterface;

interface OrdersTransformerInterface
{
    public const ARRAY_NAME = 'orders';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderInterface>
     */
    public function transform(array $data): array;
}
