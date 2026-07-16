<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

interface RunDetailInterface
{
    public function getRun(): ?string;

    public function getRunDateTime(): int;

    public function getRunFilter(): ?string;

    public function setRun(?string $value): self;

    public function setRunDateTime(int $value): self;

    public function setRunFilter(?string $value): self;
}
