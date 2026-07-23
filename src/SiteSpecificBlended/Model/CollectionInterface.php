<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface CollectionInterface
{
    /**
     * @return array<int, string>
     */
    public function getCrs(): array;

    public function getDescription(): ?string;

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
     * @return array<int, string>
     */
    public function getParameterNames(): array;

    public function getTitle(): ?string;

    /**
     * @param array<int, string> $value
     */
    public function setCrs(array $value): self;

    public function setDescription(?string $value): self;

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
     * @param array<int, string> $value
     */
    public function setParameterNames(array $value): self;

    public function setTitle(?string $value): self;
}
