<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface LocationInterface
{
    public function getId(): string;

    public function getLatitude(): ?float;

    public function getLongitude(): ?float;

    public function getName(): ?string;

    public function setId(string $value): self;

    public function setLatitude(?float $value): self;

    public function setLongitude(?float $value): self;

    public function setName(?string $value): self;
}
