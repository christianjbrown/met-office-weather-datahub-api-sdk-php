<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface LocationInterface
{
    public function getAltitude(): ?float;

    public function getId(): string;

    public function getLatitude(): ?float;

    public function getLongitude(): ?float;

    public function setAltitude(?float $value): self;

    public function setId(string $value): self;

    public function setLatitude(?float $value): self;

    public function setLongitude(?float $value): self;
}
