<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Container;

use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(RegistrarContainerFactory::class)]
final class RegistrarContainerFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testBuildRunsEveryRegistrarAgainstTheSameContainer(): void
    {
        $first = self::createMock(ServiceRegistrarInterface::class);
        $first->expects(self::once())->method('register')->with(self::isInstanceOf(ContainerBuilder::class));

        $second = self::createMock(ServiceRegistrarInterface::class);
        $second->expects(self::once())->method('register')->with(self::isInstanceOf(ContainerBuilder::class));

        $factory = new RegistrarContainerFactory([$first, $second]);

        self::assertInstanceOf(ContainerBuilder::class, $factory->build());
    }

    public function testBuildWithNoRegistrarsReturnsAnEmptyContainer(): void
    {
        $factory = new RegistrarContainerFactory([]);

        self::assertInstanceOf(ContainerBuilder::class, $factory->build());
    }
}
