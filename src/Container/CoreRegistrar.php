<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Container;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the boilerplate every DataHub API facade needs regardless of
 * which product it wires: the transport-wrapping `ApiClient`, the JSON
 * request sender built from it, and the `ApiKey` credential value object.
 * Reused by all five facades so this wiring exists exactly once.
 */
final class CoreRegistrar implements ServiceRegistrarInterface
{
    private string $apiKey;
    private string $serviceApiClient;
    private string $serviceApiKey;
    private string $serviceJsonApiRequestSender;

    public function __construct(string $serviceApiClient, string $serviceJsonApiRequestSender, string $serviceApiKey, string $apiKey)
    {
        $this->serviceApiClient = $serviceApiClient;
        $this->serviceJsonApiRequestSender = $serviceJsonApiRequestSender;
        $this->serviceApiKey = $serviceApiKey;
        $this->apiKey = $apiKey;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register($this->serviceApiClient, ApiClient::class);
        $container->register($this->serviceJsonApiRequestSender, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference($this->serviceApiClient), 'getJsonApiRequestSender']);

        $container->register($this->serviceApiKey, ApiKey::class)
            ->setArguments(
                [
                    $this->apiKey,
                ]
            );
    }
}
