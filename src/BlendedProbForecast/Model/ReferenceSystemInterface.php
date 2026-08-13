<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface ReferenceSystemInterface
{
    public function getCalendar(): ?string;

    /**
     * @return array<int, string>
     */
    public function getCoordinates(): array;

    public function getId(): ?string;

    /**
     * @return array<array-key, string>
     */
    public function getIdentifiers(): array;

    public function getLabel(): ?string;

    public function getType(): ?string;

    public function setCalendar(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setCoordinates(array $value): self;

    public function setId(?string $value): self;

    /**
     * @param array<array-key, string> $value
     */
    public function setIdentifiers(array $value): self;

    public function setLabel(?string $value): self;

    public function setType(?string $value): self;
}
