<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface CoverageCollectionInterface
{
    /**
     * @return array<int, CoverageInterface>
     */
    public function getCoverages(): array;

    public function getDomainType(): ?string;

    /**
     * @return array<int, ReferenceSystemInterface>
     */
    public function getReferencing(): array;

    /**
     * @param array<int, CoverageInterface> $value
     */
    public function setCoverages(array $value): self;

    public function setDomainType(?string $value): self;

    /**
     * @param array<int, ReferenceSystemInterface> $value
     */
    public function setReferencing(array $value): self;
}
