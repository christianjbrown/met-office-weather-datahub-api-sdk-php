<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Model;

final class NearestLocation implements NearestLocationInterface
{
    private ?string $area = null;
    private ?string $country = null;
    private string $geohash;
    private ?string $olsonTimeZone = null;
    private ?string $region = null;

    public function __construct(string $geohash)
    {
        $this->geohash = $geohash;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getGeohash(): string
    {
        return $this->geohash;
    }

    public function getOlsonTimeZone(): ?string
    {
        return $this->olsonTimeZone;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setArea(?string $value): NearestLocationInterface
    {
        $this->area = $value;

        return $this;
    }

    public function setCountry(?string $value): NearestLocationInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setGeohash(string $value): NearestLocationInterface
    {
        $this->geohash = $value;

        return $this;
    }

    public function setOlsonTimeZone(?string $value): NearestLocationInterface
    {
        $this->olsonTimeZone = $value;

        return $this;
    }

    public function setRegion(?string $value): NearestLocationInterface
    {
        $this->region = $value;

        return $this;
    }
}
