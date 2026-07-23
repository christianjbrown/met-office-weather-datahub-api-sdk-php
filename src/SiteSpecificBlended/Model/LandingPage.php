<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class LandingPage implements LandingPageInterface
{
    private ?string $description = null;

    /**
     * @var array<int, LinkInterface>
     */
    private array $links = [];
    private ?string $title = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, LinkInterface>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(?string $value): LandingPageInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param array<int, LinkInterface> $value
     */
    public function setLinks(array $value): LandingPageInterface
    {
        $this->links = $value;

        return $this;
    }

    public function setTitle(?string $value): LandingPageInterface
    {
        $this->title = $value;

        return $this;
    }
}
