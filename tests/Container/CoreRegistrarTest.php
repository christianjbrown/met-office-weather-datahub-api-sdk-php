<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Container;

use ChristianBrown\ApiClient\ApiClientInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CoreRegistrar::class)]
#[UsesClass(ApiKey::class)]
final class CoreRegistrarTest extends TestCase
{
    public function testRegisterWiresTheSharedTransportServices(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar('api_client', 'json_api_request_sender', 'api_key', 'test-api-key'))
            ->register($container);

        self::assertSame(ApiClientInterface::class, $container->getDefinition('api_client')->getClass());
        self::assertSame(JsonApiRequestSenderInterface::class, $container->getDefinition('json_api_request_sender')->getClass());

        /**
         * @var ApiKeyInterface $apiKey
         */
        $apiKey = $container->get('api_key');
        self::assertSame(['apikey' => 'test-api-key'], $apiKey->toHeaders());
    }
}
