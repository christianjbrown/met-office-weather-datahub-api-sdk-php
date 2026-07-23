<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface CoverageInterface
{
    public function getDomain(): DomainInterface;

    /**
     * @return array<string, NdArrayInterface>
     */
    public function getRanges(): array;

    public function setDomain(DomainInterface $value): self;

    /**
     * @param array<string, NdArrayInterface> $value
     */
    public function setRanges(array $value): self;
}
