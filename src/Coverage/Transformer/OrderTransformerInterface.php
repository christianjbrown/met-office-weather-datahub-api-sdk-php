<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderInterface;

interface OrderTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_FORMAT = 'format';
    public const string KEY_MODEL_ID = 'modelId';
    public const string KEY_NAME = 'name';
    public const string KEY_ORDER_ID = 'orderId';
    public const string KEY_REGIONS = 'regions';
    public const string KEY_REQUIRED_LATEST_RUNS = 'requiredLatestRuns';
    public const string KEY_TIMESTEPS = 'timesteps';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderInterface;
}
