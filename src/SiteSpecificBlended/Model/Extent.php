<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Extent implements ExtentInterface
{
    /**
     * @var array<int, float>
     */
    private array $spatialBbox = [];
    private ?string $spatialCrs = null;

    /**
     * @var array<int, string>
     */
    private array $temporalInterval = [];

    /**
     * @var array<int, string>
     */
    private array $temporalValues = [];

    /**
     * @var array<int, float>
     */
    private array $verticalValues = [];

    /**
     * @return array<int, float>
     */
    public function getSpatialBbox(): array
    {
        return $this->spatialBbox;
    }

    public function getSpatialCrs(): ?string
    {
        return $this->spatialCrs;
    }

    /**
     * @return array<int, string>
     */
    public function getTemporalInterval(): array
    {
        return $this->temporalInterval;
    }

    /**
     * @return array<int, string>
     */
    public function getTemporalValues(): array
    {
        return $this->temporalValues;
    }

    /**
     * @return array<int, float>
     */
    public function getVerticalValues(): array
    {
        return $this->verticalValues;
    }

    /**
     * @param array<int, float> $value
     */
    public function setSpatialBbox(array $value): ExtentInterface
    {
        $this->spatialBbox = $value;

        return $this;
    }

    public function setSpatialCrs(?string $value): ExtentInterface
    {
        $this->spatialCrs = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTemporalInterval(array $value): ExtentInterface
    {
        $this->temporalInterval = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTemporalValues(array $value): ExtentInterface
    {
        $this->temporalValues = $value;

        return $this;
    }

    /**
     * @param array<int, float> $value
     */
    public function setVerticalValues(array $value): ExtentInterface
    {
        $this->verticalValues = $value;

        return $this;
    }
}
