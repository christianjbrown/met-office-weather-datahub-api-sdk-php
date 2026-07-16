<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Model;

interface NearestLocationInterface
{
    public function getArea(): ?string;

    public function getCountry(): ?string;

    public function getGeohash(): string;

    public function getOlsonTimeZone(): ?string;

    public function getRegion(): ?string;

    public function setArea(?string $value): self;

    public function setCountry(?string $value): self;

    public function setGeohash(string $value): self;

    public function setOlsonTimeZone(?string $value): self;

    public function setRegion(?string $value): self;
}
