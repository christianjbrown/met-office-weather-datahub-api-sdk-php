<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Collection implements CollectionInterface
{
    /**
     * @var array<int, string>
     */
    private array $crs = [];
    private ?string $description = null;
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
     * @var array<int, string>
     */
    private array $parameterNames = [];
    private ?string $title = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
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
     * @return array<int, string>
     */
    public function getParameterNames(): array
    {
        return $this->parameterNames;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param array<int, string> $value
     */
    public function setCrs(array $value): CollectionInterface
    {
        $this->crs = $value;

        return $this;
    }

    public function setDescription(?string $value): CollectionInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setExtent(?ExtentInterface $value): CollectionInterface
    {
        $this->extent = $value;

        return $this;
    }

    public function setId(string $value): CollectionInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<int, LinkInterface> $value
     */
    public function setLinks(array $value): CollectionInterface
    {
        $this->links = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setOutputFormats(array $value): CollectionInterface
    {
        $this->outputFormats = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setParameterNames(array $value): CollectionInterface
    {
        $this->parameterNames = $value;

        return $this;
    }

    public function setTitle(?string $value): CollectionInterface
    {
        $this->title = $value;

        return $this;
    }
}
