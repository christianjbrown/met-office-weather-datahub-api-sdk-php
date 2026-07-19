<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Model;

interface OrderInterface
{
    public function getDescription(): ?string;

    public function getFormat(): ?string;

    public function getModelId(): ?string;

    public function getName(): ?string;

    public function getOrderId(): string;

    /**
     * @return array<int, RegionInterface>
     */
    public function getRegions(): array;

    /**
     * @return array<int, string>
     */
    public function getRequiredLatestRuns(): array;

    /**
     * @return array<int, string>
     */
    public function getTimesteps(): array;

    public function setDescription(?string $value): self;

    public function setFormat(?string $value): self;

    public function setModelId(?string $value): self;

    public function setName(?string $value): self;

    public function setOrderId(string $value): self;

    /**
     * @param array<int, RegionInterface> $value
     */
    public function setRegions(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setRequiredLatestRuns(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setTimesteps(array $value): self;
}
