<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

interface ParameterMetadataInterface
{
    public function getDescription(): ?string;

    public function getType(): ?string;

    public function getUnitLabel(): ?string;

    public function getUnitSymbolType(): ?string;

    public function getUnitSymbolValue(): ?string;

    public function setDescription(?string $value): self;

    public function setType(?string $value): self;

    public function setUnitLabel(?string $value): self;

    public function setUnitSymbolType(?string $value): self;

    public function setUnitSymbolValue(?string $value): self;
}
