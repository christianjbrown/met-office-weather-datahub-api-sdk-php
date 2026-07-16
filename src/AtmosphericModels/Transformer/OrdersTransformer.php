<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class OrdersTransformer implements OrdersTransformerInterface
{
    private OrderTransformerInterface $orderTransformer;

    public function __construct(OrderTransformerInterface $orderTransformer)
    {
        $this->orderTransformer = $orderTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderInterface>
     */
    public function transform(array $data): array
    {
        $orders = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $orderData = $values[$i];
            if (!is_array($orderData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $orders[] = $this->orderTransformer->transform($orderData);
        }

        return $orders;
    }
}
