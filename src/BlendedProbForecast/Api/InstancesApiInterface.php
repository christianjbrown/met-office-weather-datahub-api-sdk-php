<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;

interface InstancesApiInterface extends ApiInterface
{
    public function getInstance(string $collectionId, string $instanceId): InstanceInterface;

    /**
     * @return array<int, InstanceInterface>
     */
    public function getInstances(string $collectionId): array;
}
