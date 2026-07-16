<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

final class OrderFile implements OrderFileInterface
{
    private string $fileId;

    /**
     * @var array<int, string>
     */
    private array $levels = [];

    /**
     * @var array<int, string>
     */
    private array $parameters = [];
    private ?RegionInterface $region = null;
    private ?string $run = null;
    private ?int $runDateTime = null;
    private ?string $surfaceId = null;

    /**
     * @var array<int, string>
     */
    private array $timesteps = [];

    public function __construct(string $fileId)
    {
        $this->fileId = $fileId;
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @return array<int, string>
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    /**
     * @return array<int, string>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getRegion(): ?RegionInterface
    {
        return $this->region;
    }

    public function getRun(): ?string
    {
        return $this->run;
    }

    public function getRunDateTime(): ?int
    {
        return $this->runDateTime;
    }

    public function getSurfaceId(): ?string
    {
        return $this->surfaceId;
    }

    /**
     * @return array<int, string>
     */
    public function getTimesteps(): array
    {
        return $this->timesteps;
    }

    public function setFileId(string $value): OrderFileInterface
    {
        $this->fileId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setLevels(array $value): OrderFileInterface
    {
        $this->levels = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setParameters(array $value): OrderFileInterface
    {
        $this->parameters = $value;

        return $this;
    }

    public function setRegion(?RegionInterface $value): OrderFileInterface
    {
        $this->region = $value;

        return $this;
    }

    public function setRun(?string $value): OrderFileInterface
    {
        $this->run = $value;

        return $this;
    }

    public function setRunDateTime(?int $value): OrderFileInterface
    {
        $this->runDateTime = $value;

        return $this;
    }

    public function setSurfaceId(?string $value): OrderFileInterface
    {
        $this->surfaceId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTimesteps(array $value): OrderFileInterface
    {
        $this->timesteps = $value;

        return $this;
    }
}
