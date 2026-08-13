<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class Instance implements InstanceInterface
{
    /**
     * @var array<int, string>
     */
    private array $crs = [];

    /**
     * @var array<int, string>
     */
    private array $dataQueries = [];
    private ?ExtentInterface $extent = null;
    private string $id;

    /**
     * @var array<int, LinkInterface>
     */
    private array $links = [];

    /**
     * @var array<int, string>
     */
    private array $outputFormats = [];

    /**
     * @var array<string, ParameterInterface>
     */
    private array $parameters = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array<int, string>
     */
    public function getCrs(): array
    {
        return $this->crs;
    }

    /**
     * @return array<int, string>
     */
    public function getDataQueries(): array
    {
        return $this->dataQueries;
    }

    public function getExtent(): ?ExtentInterface
    {
        return $this->extent;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, LinkInterface>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @return array<int, string>
     */
    public function getOutputFormats(): array
    {
        return $this->outputFormats;
    }

    /**
     * @return array<string, ParameterInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array<int, string> $value
     */
    public function setCrs(array $value): InstanceInterface
    {
        $this->crs = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setDataQueries(array $value): InstanceInterface
    {
        $this->dataQueries = $value;

        return $this;
    }

    public function setExtent(?ExtentInterface $value): InstanceInterface
    {
        $this->extent = $value;

        return $this;
    }

    public function setId(string $value): InstanceInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<int, LinkInterface> $value
     */
    public function setLinks(array $value): InstanceInterface
    {
        $this->links = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setOutputFormats(array $value): InstanceInterface
    {
        $this->outputFormats = $value;

        return $this;
    }

    /**
     * @param array<string, ParameterInterface> $value
     */
    public function setParameters(array $value): InstanceInterface
    {
        $this->parameters = $value;

        return $this;
    }
}
