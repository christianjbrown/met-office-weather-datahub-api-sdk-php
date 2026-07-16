<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderInterface;

interface OrderTransformerInterface
{
    public const KEY_DESCRIPTION = 'description';
    public const KEY_FORMAT = 'format';
    public const KEY_MODEL_ID = 'modelId';
    public const KEY_NAME = 'name';
    public const KEY_ORDER_ID = 'orderId';
    public const KEY_REGIONS = 'regions';
    public const KEY_REQUIRED_LATEST_RUNS = 'requiredLatestRuns';
    public const KEY_TIMESTEPS = 'timesteps';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderInterface;
}
