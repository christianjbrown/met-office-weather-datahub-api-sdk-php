<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Container;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the raw (non-JSON) request sender used by the two coverage-order
 * products (Atmospheric Models, Map Images) to download binary order files.
 * Kept separate from `CoreRegistrar` because the other three products never
 * need it.
 */
final class RawRequestSenderRegistrar implements ServiceRegistrarInterface
{
    private string $serviceApiClient;
    private string $serviceRawApiRequestSender;

    public function __construct(string $serviceApiClient, string $serviceRawApiRequestSender)
    {
        $this->serviceApiClient = $serviceApiClient;
        $this->serviceRawApiRequestSender = $serviceRawApiRequestSender;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register($this->serviceRawApiRequestSender, ApiRequestSenderInterface::class)
            ->setFactory([new Reference($this->serviceApiClient), 'getApiRequestSender']);
    }
}
