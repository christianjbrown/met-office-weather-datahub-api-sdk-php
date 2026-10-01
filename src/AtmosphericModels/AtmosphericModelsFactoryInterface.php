<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels;

use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

interface AtmosphericModelsFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): AtmosphericModelsInterface;
}
