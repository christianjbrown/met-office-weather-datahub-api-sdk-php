<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Container\RunsApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\TransformersRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(RunsApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(TransformersRegistrar::class)]
final class RunsApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheRunsApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            AtmosphericModelsInterface::SERVICE_API_CLIENT,
            AtmosphericModelsInterface::SERVICE_JSON_API_REQUEST_SENDER,
            AtmosphericModelsInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new TransformersRegistrar())->register($container);
        (new RunsApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(RunsApi::class, $container->getDefinition(AtmosphericModelsInterface::SERVICE_RUNS_API)->getClass());
    }
}
