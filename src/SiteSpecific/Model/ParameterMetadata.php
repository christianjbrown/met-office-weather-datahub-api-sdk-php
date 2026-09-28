<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

final class ParameterMetadata implements ParameterMetadataInterface
{
    private ?string $description = null;
    private ?string $type = null;
    private ?string $unitLabel = null;
    private ?string $unitSymbolType = null;
    private ?string $unitSymbolValue = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUnitLabel(): ?string
    {
        return $this->unitLabel;
    }

    public function getUnitSymbolType(): ?string
    {
        return $this->unitSymbolType;
    }

    public function getUnitSymbolValue(): ?string
    {
        return $this->unitSymbolValue;
    }

    public function setDescription(?string $value): ParameterMetadataInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setType(?string $value): ParameterMetadataInterface
    {
        $this->type = $value;

        return $this;
    }

    public function setUnitLabel(?string $value): ParameterMetadataInterface
    {
        $this->unitLabel = $value;

        return $this;
    }

    public function setUnitSymbolType(?string $value): ParameterMetadataInterface
    {
        $this->unitSymbolType = $value;

        return $this;
    }

    public function setUnitSymbolValue(?string $value): ParameterMetadataInterface
    {
        $this->unitSymbolValue = $value;

        return $this;
    }
}
