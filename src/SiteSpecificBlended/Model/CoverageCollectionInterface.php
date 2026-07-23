<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface CoverageCollectionInterface
{
    /**
     * @return array<int, CoverageInterface>
     */
    public function getCoverages(): array;

    public function getDomainType(): ?string;

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array;

    /**
     * @param array<int, CoverageInterface> $value
     */
    public function setCoverages(array $value): self;

    public function setDomainType(?string $value): self;

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): self;
}
