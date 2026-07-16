<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

final class Order implements OrderInterface
{
    private ?string $description = null;
    private ?string $format = null;
    private ?string $modelId = null;
    private ?string $name = null;
    private string $orderId;

    /**
     * @var array<int, RegionInterface>
     */
    private array $regions = [];

    /**
     * @var array<int, string>
     */
    private array $requiredLatestRuns = [];

    /**
     * @var array<int, string>
     */
    private array $timesteps = [];

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getModelId(): ?string
    {
        return $this->modelId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return array<int, RegionInterface>
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * @return array<int, string>
     */
    public function getRequiredLatestRuns(): array
    {
        return $this->requiredLatestRuns;
    }

    /**
     * @return array<int, string>
     */
    public function getTimesteps(): array
    {
        return $this->timesteps;
    }

    public function setDescription(?string $value): OrderInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setFormat(?string $value): OrderInterface
    {
        $this->format = $value;

        return $this;
    }

    public function setModelId(?string $value): OrderInterface
    {
        $this->modelId = $value;

        return $this;
    }

    public function setName(?string $value): OrderInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOrderId(string $value): OrderInterface
    {
        $this->orderId = $value;

        return $this;
    }

    /**
     * @param array<int, RegionInterface> $value
     */
    public function setRegions(array $value): OrderInterface
    {
        $this->regions = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setRequiredLatestRuns(array $value): OrderInterface
    {
        $this->requiredLatestRuns = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTimesteps(array $value): OrderInterface
    {
        $this->timesteps = $value;

        return $this;
    }
}
