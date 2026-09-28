<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ParametersTransformerRegistrar::class)]
final class ParametersTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheParameterTransformerPair(): void
    {
        $container = new ContainerBuilder();

        (new ParametersTransformerRegistrar())->register($container);

        self::assertSame(ParametersTransformer::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_PARAMETERS_TRANSFORMER)->getClass());
    }
}
