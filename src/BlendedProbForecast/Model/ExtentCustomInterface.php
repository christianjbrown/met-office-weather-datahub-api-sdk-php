<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface ExtentCustomInterface
{
    public function getId(): string;

    /**
     * @return array<int, string>
     */
    public function getInterval(): array;

    public function getReference(): ?string;

    /**
     * @return array<int, string>
     */
    public function getValues(): array;

    public function setId(string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setInterval(array $value): self;

    public function setReference(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setValues(array $value): self;
}
