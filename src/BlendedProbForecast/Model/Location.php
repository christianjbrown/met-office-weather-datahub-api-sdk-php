<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class Location implements LocationInterface
{
    private ?float $altitude = null;
    private string $id;
    private ?float $latitude = null;
    private ?float $longitude = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setAltitude(?float $value): LocationInterface
    {
        $this->altitude = $value;

        return $this;
    }

    public function setId(string $value): LocationInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setLatitude(?float $value): LocationInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLongitude(?float $value): LocationInterface
    {
        $this->longitude = $value;

        return $this;
    }
}
