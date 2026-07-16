<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

interface OrderFileDetailsInterface
{
    public function getFile(): OrderFileInterface;

    /**
     * @return array<int, ParameterDetailInterface>
     */
    public function getParameterDetails(): array;

    public function setFile(OrderFileInterface $value): self;

    /**
     * @param array<int, ParameterDetailInterface> $value
     */
    public function setParameterDetails(array $value): self;
}
