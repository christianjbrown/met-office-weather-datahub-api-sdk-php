<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Link implements LinkInterface
{
    private string $href;
    private ?string $hrefLang = null;
    private ?string $rel = null;
    private ?string $title = null;
    private ?string $type = null;

    public function __construct(string $href)
    {
        $this->href = $href;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getHrefLang(): ?string
    {
        return $this->hrefLang;
    }

    public function getRel(): ?string
    {
        return $this->rel;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setHref(string $value): LinkInterface
    {
        $this->href = $value;

        return $this;
    }

    public function setHrefLang(?string $value): LinkInterface
    {
        $this->hrefLang = $value;

        return $this;
    }

    public function setRel(?string $value): LinkInterface
    {
        $this->rel = $value;

        return $this;
    }

    public function setTitle(?string $value): LinkInterface
    {
        $this->title = $value;

        return $this;
    }

    public function setType(?string $value): LinkInterface
    {
        $this->type = $value;

        return $this;
    }
}
