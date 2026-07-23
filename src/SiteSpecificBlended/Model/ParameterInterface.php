<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface ParameterInterface
{
    public function getDescription(): ?string;

    public function getId(): string;

    public function getObservedPropertyId(): ?string;

    public function getObservedPropertyLabel(): ?string;

    public function getUnit(): ?string;

    public function setDescription(?string $value): self;

    public function setId(string $value): self;

    public function setObservedPropertyId(?string $value): self;

    public function setObservedPropertyLabel(?string $value): self;

    public function setUnit(?string $value): self;
}
