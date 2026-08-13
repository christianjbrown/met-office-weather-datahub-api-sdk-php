<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface CoverageInterface
{
    public function getDomain(): DomainInterface;

    public function getId(): ?string;

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array;

    /**
     * @return array<string, NdArrayInterface>
     */
    public function getRanges(): array;

    public function setDomain(DomainInterface $value): self;

    public function setId(?string $value): self;

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): self;

    /**
     * @param array<string, NdArrayInterface> $value
     */
    public function setRanges(array $value): self;
}
