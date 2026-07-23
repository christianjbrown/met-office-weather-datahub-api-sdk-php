<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Coverage implements CoverageInterface
{
    private DomainInterface $domain;

    /**
     * @var array<string, NdArrayInterface>
     */
    private array $ranges = [];

    public function __construct(DomainInterface $domain)
    {
        $this->domain = $domain;
    }

    public function getDomain(): DomainInterface
    {
        return $this->domain;
    }

    /**
     * @return array<string, NdArrayInterface>
     */
    public function getRanges(): array
    {
        return $this->ranges;
    }

    public function setDomain(DomainInterface $value): CoverageInterface
    {
        $this->domain = $value;

        return $this;
    }

    /**
     * @param array<string, NdArrayInterface> $value
     */
    public function setRanges(array $value): CoverageInterface
    {
        $this->ranges = $value;

        return $this;
    }
}
