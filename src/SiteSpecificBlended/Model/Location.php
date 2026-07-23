<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Location implements LocationInterface
{
    private string $id;
    private ?float $latitude = null;
    private ?float $longitude = null;
    private ?string $name = null;

    public function __construct(string $id)
    {
        $this->id = $id;
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

    public function getName(): ?string
    {
        return $this->name;
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

    public function setName(?string $value): LocationInterface
    {
        $this->name = $value;

        return $this;
    }
}
