<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_map;

/**
 * Runs a fixed, ordered list of registrars against one freshly built
 * container. Each API facade supplies its own registrar list; adding a new
 * DataHub API group means adding a registrar to that list, not editing this
 * class.
 */
final class RegistrarContainerFactory implements ContainerFactoryInterface
{
    /**
     * @var ServiceRegistrarInterface[]
     */
    private array $registrars;

    /**
     * @param ServiceRegistrarInterface[] $registrars
     */
    public function __construct(array $registrars)
    {
        $this->registrars = $registrars;
    }

    public function build(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        array_map(static function (ServiceRegistrarInterface $registrar) use ($container): bool {
            $registrar->register($container);

            return true;
        }, $this->registrars);

        return $container;
    }
}
