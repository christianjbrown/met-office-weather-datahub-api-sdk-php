<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class CoverageCollection implements CoverageCollectionInterface
{
    /**
     * @var array<int, CoverageInterface>
     */
    private array $coverages = [];
    private ?string $domainType = null;

    /**
     * @var array<int, ReferenceSystemInterface>
     */
    private array $referencing = [];

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
     * @return array<int, ReferenceSystemInterface>
     */
    public function getReferencing(): array
    {
        return $this->referencing;
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
     * @param array<int, ReferenceSystemInterface> $value
     */
    public function setReferencing(array $value): CoverageCollectionInterface
    {
        $this->referencing = $value;

        return $this;
    }
}
