<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LinksTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(LinksTransformerRegistrar::class)]
final class LinksTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheLinkTransformerPair(): void
    {
        $container = new ContainerBuilder();

        (new LinksTransformerRegistrar())->register($container);

        self::assertSame(LinkTransformer::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINK_TRANSFORMER)->getClass());
        self::assertSame(LinksTransformer::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINKS_TRANSFORMER)->getClass());
    }
}
