<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class Parameter implements ParameterInterface
{
    private ?string $description = null;
    private ?string $fileSuffix = null;
    private ?string $height = null;
    private string $id;
    private ?string $observedPropertyId = null;
    private ?string $observedPropertyLabel = null;
    private ?string $unit = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFileSuffix(): ?string
    {
        return $this->fileSuffix;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getObservedPropertyId(): ?string
    {
        return $this->observedPropertyId;
    }

    public function getObservedPropertyLabel(): ?string
    {
        return $this->observedPropertyLabel;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setDescription(?string $value): ParameterInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setFileSuffix(?string $value): ParameterInterface
    {
        $this->fileSuffix = $value;

        return $this;
    }

    public function setHeight(?string $value): ParameterInterface
    {
        $this->height = $value;

        return $this;
    }

    public function setId(string $value): ParameterInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setObservedPropertyId(?string $value): ParameterInterface
    {
        $this->observedPropertyId = $value;

        return $this;
    }

    public function setObservedPropertyLabel(?string $value): ParameterInterface
    {
        $this->observedPropertyLabel = $value;

        return $this;
    }

    public function setUnit(?string $value): ParameterInterface
    {
        $this->unit = $value;

        return $this;
    }
}
