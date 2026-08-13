<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface InstanceInterface
{
    /**
     * @return array<int, string>
     */
    public function getCrs(): array;

    /**
     * @return array<int, string>
     */
    public function getDataQueries(): array;

    public function getExtent(): ?ExtentInterface;

    public function getId(): string;

    /**
     * @return array<int, LinkInterface>
     */
    public function getLinks(): array;

    /**
     * @return array<int, string>
     */
    public function getOutputFormats(): array;

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array;

    /**
     * @param array<int, string> $value
     */
    public function setCrs(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setDataQueries(array $value): self;

    public function setExtent(?ExtentInterface $value): self;

    public function setId(string $value): self;

    /**
     * @param array<int, LinkInterface> $value
     */
    public function setLinks(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setOutputFormats(array $value): self;

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): self;
}
