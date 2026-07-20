<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\Order;
use ChristianBrown\MetOffice\Coverage\Model\OrderInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class OrderTransformer implements OrderTransformerInterface
{
    private RegionsTransformerInterface $regionsTransformer;

    public function __construct(RegionsTransformerInterface $regionsTransformer)
    {
        $this->regionsTransformer = $regionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderInterface
    {
        if (empty($data[self::KEY_ORDER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ORDER_ID));
        }
        if (!is_string($data[self::KEY_ORDER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ORDER_ID));
        }
        $order = new Order($data[self::KEY_ORDER_ID]);

        $this->applyDescription($order, $data);
        $this->applyFormat($order, $data);
        $this->applyModelId($order, $data);
        $this->applyName($order, $data);
        $this->applyRegions($order, $data);
        $this->applyRequiredLatestRuns($order, $data);
        $this->applyTimesteps($order, $data);

        return $order;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDescription(Order $order, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $order->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFormat(Order $order, array $data): void
    {
        if (empty($data[self::KEY_FORMAT])) {
            return;
        }
        if (!is_string($data[self::KEY_FORMAT])) {
            return;
        }
        $order->setFormat($data[self::KEY_FORMAT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyModelId(Order $order, array $data): void
    {
        if (empty($data[self::KEY_MODEL_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL_ID])) {
            return;
        }
        $order->setModelId($data[self::KEY_MODEL_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyName(Order $order, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $order->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegions(Order $order, array $data): void
    {
        if (!isset($data[self::KEY_REGIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_REGIONS])) {
            return;
        }
        $order->setRegions($this->regionsTransformer->transform($data[self::KEY_REGIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRequiredLatestRuns(Order $order, array $data): void
    {
        if (!isset($data[self::KEY_REQUIRED_LATEST_RUNS])) {
            return;
        }
        if (!is_array($data[self::KEY_REQUIRED_LATEST_RUNS])) {
            return;
        }
        $order->setRequiredLatestRuns($this->toStringArray($data[self::KEY_REQUIRED_LATEST_RUNS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTimesteps(Order $order, array $data): void
    {
        if (!isset($data[self::KEY_TIMESTEPS])) {
            return;
        }
        if (!is_array($data[self::KEY_TIMESTEPS])) {
            return;
        }
        $order->setTimesteps($this->toStringArray($data[self::KEY_TIMESTEPS]));
    }

    /**
     * @param mixed[] $values
     *
     * @return array<int, string>
     */
    private function toStringArray(array $values): array
    {
        return array_values(array_filter($values, static fn (mixed $value): bool => is_string($value)));
    }
}
