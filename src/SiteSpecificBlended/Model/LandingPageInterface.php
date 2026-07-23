<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface LandingPageInterface
{
    public function getDescription(): ?string;

    /**
     * @return array<int, LinkInterface>
     */
    public function getLinks(): array;

    public function getTitle(): ?string;

    public function setDescription(?string $value): self;

    /**
     * @param array<int, LinkInterface> $value
     */
    public function setLinks(array $value): self;

    public function setTitle(?string $value): self;
}
