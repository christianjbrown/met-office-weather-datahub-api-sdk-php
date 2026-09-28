<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `Link`/`Links` transformer pair, reused by the landing page,
 * collection, and instance transformers.
 */
final class LinksTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_LINK_TRANSFORMER, LinkTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_LINKS_TRANSFORMER, LinksTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINK_TRANSFORMER),
                ]
            );
    }
}
