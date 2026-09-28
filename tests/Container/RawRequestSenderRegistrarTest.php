<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Container;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(RawRequestSenderRegistrar::class)]
#[UsesClass(CoreRegistrar::class)]
final class RawRequestSenderRegistrarTest extends TestCase
{
    public function testRegisterWiresTheRawRequestSender(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar('api_client', 'json_api_request_sender', 'api_key', 'test-api-key'))
            ->register($container);
        (new RawRequestSenderRegistrar('api_client', 'api_request_sender'))
            ->register($container);

        self::assertSame(ApiRequestSenderInterface::class, $container->getDefinition('api_request_sender')->getClass());
    }
}
