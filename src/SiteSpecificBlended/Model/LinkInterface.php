<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface LinkInterface
{
    public function getHref(): string;

    public function getHrefLang(): ?string;

    public function getRel(): ?string;

    public function getTitle(): ?string;

    public function getType(): ?string;

    public function setHref(string $value): self;

    public function setHrefLang(?string $value): self;

    public function setRel(?string $value): self;

    public function setTitle(?string $value): self;

    public function setType(?string $value): self;
}
