<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class CoverageCollection implements CoverageCollectionInterface
{
    /**
     * @var array<int, CoverageInterface>
     */
    private array $coverages = [];
    private ?string $domainType = null;

    /**
     * @var array<string, ParameterInterface>
     */
    private array $parameters = [];

    /**
     * @return array<int, CoverageInterface>
     */
    public function getCoverages(): array
    {
        return $this->coverages;
    }

    public function getDomainType(): ?string
    {
        return $this->domainType;
    }

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array<int, CoverageInterface> $value
     */
    public function setCoverages(array $value): CoverageCollectionInterface
    {
        $this->coverages = $value;

        return $this;
    }

    public function setDomainType(?string $value): CoverageCollectionInterface
    {
        $this->domainType = $value;

        return $this;
    }

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): CoverageCollectionInterface
    {
        $this->parameters = $value;

        return $this;
    }
}
