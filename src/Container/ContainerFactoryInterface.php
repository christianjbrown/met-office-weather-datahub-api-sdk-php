<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ContainerFactoryInterface
{
    public function build(): ContainerBuilder;
}
