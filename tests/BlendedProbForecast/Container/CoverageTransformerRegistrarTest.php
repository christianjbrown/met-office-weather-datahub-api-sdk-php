<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CoverageTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CoverageTransformerRegistrar::class)]
#[UsesClass(ParametersTransformerRegistrar::class)]
final class CoverageTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheCoverageTransformerChain(): void
    {
        $container = new ContainerBuilder();

        (new ParametersTransformerRegistrar())->register($container);
        (new CoverageTransformerRegistrar())->register($container);

        self::assertSame(CoverageCollectionTransformer::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_COVERAGE_COLLECTION_TRANSFORMER)->getClass());
    }
}
