<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

interface OrderFileInterface
{
    public function getFileId(): string;

    /**
     * @return array<int, string>
     */
    public function getLevels(): array;

    /**
     * @return array<int, string>
     */
    public function getParameters(): array;

    public function getRegion(): ?RegionInterface;

    public function getRun(): ?string;

    public function getRunDateTime(): ?int;

    public function getSurfaceId(): ?string;

    /**
     * @return array<int, string>
     */
    public function getTimesteps(): array;

    public function setFileId(string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setLevels(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setParameters(array $value): self;

    public function setRegion(?RegionInterface $value): self;

    public function setRun(?string $value): self;

    public function setRunDateTime(?int $value): self;

    public function setSurfaceId(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setTimesteps(array $value): self;
}
