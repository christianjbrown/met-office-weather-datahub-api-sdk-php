<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ExtentTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ExtentTransformerRegistrar::class)]
final class ExtentTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheExtentTransformerChain(): void
    {
        $container = new ContainerBuilder();

        (new ExtentTransformerRegistrar())->register($container);

        self::assertSame(ExtentTransformer::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_EXTENT_TRANSFORMER)->getClass());
    }
}
