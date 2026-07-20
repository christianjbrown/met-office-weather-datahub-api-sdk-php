<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetails;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetailsInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function sprintf;

final class OrderFileDetailsTransformer implements OrderFileDetailsTransformerInterface
{
    private OrderFileTransformerInterface $orderFileTransformer;
    private ParameterDetailsTransformerInterface $parameterDetailsTransformer;

    public function __construct(OrderFileTransformerInterface $orderFileTransformer, ParameterDetailsTransformerInterface $parameterDetailsTransformer)
    {
        $this->orderFileTransformer = $orderFileTransformer;
        $this->parameterDetailsTransformer = $parameterDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileDetailsInterface
    {
        if (!isset($data[self::KEY_FILE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_FILE));
        }
        if (!is_array($data[self::KEY_FILE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_FILE));
        }
        $orderFileDetails = new OrderFileDetails($this->orderFileTransformer->transform($data[self::KEY_FILE]));

        $this->applyParameterDetails($orderFileDetails, $data);

        return $orderFileDetails;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameterDetails(OrderFileDetails $orderFileDetails, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETER_DETAILS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETER_DETAILS])) {
            return;
        }
        $orderFileDetails->setParameterDetails($this->parameterDetailsTransformer->transform($data[self::KEY_PARAMETER_DETAILS]));
    }
}
