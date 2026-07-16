<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class OrderFilesTransformer implements OrderFilesTransformerInterface
{
    private OrderFileTransformerInterface $orderFileTransformer;

    public function __construct(OrderFileTransformerInterface $orderFileTransformer)
    {
        $this->orderFileTransformer = $orderFileTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderFileInterface>
     */
    public function transform(array $data): array
    {
        $orderFiles = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $orderFileData = $values[$i];
            if (!is_array($orderFileData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $orderFiles[] = $this->orderFileTransformer->transform($orderFileData);
        }

        return $orderFiles;
    }
}
