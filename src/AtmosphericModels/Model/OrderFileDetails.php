<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

final class OrderFileDetails implements OrderFileDetailsInterface
{
    private OrderFileInterface $file;

    /**
     * @var array<int, ParameterDetailInterface>
     */
    private array $parameterDetails = [];

    public function __construct(OrderFileInterface $file)
    {
        $this->file = $file;
    }

    public function getFile(): OrderFileInterface
    {
        return $this->file;
    }

    /**
     * @return array<int, ParameterDetailInterface>
     */
    public function getParameterDetails(): array
    {
        return $this->parameterDetails;
    }

    public function setFile(OrderFileInterface $value): OrderFileDetailsInterface
    {
        $this->file = $value;

        return $this;
    }

    /**
     * @param array<int, ParameterDetailInterface> $value
     */
    public function setParameterDetails(array $value): OrderFileDetailsInterface
    {
        $this->parameterDetails = $value;

        return $this;
    }
}
