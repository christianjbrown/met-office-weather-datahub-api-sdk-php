<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class Coverage implements CoverageInterface
{
    private DomainInterface $domain;
    private ?string $id = null;

    /**
     * @var array<string, ParameterInterface>
     */
    private array $parameters = [];

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

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
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

    public function setId(?string $value): CoverageInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): CoverageInterface
    {
        $this->parameters = $value;

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
