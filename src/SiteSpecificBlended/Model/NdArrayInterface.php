<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface NdArrayInterface
{
    /**
     * @return array<int, string>
     */
    public function getAxisNames(): array;

    public function getDataType(): ?string;

    public function getId(): string;

    /**
     * @return array<int, int>
     */
    public function getShape(): array;

    /**
     * @return array<int, null|float>
     */
    public function getValues(): array;

    /**
     * @param array<int, string> $value
     */
    public function setAxisNames(array $value): self;

    public function setDataType(?string $value): self;

    public function setId(string $value): self;

    /**
     * @param array<int, int> $value
     */
    public function setShape(array $value): self;

    /**
     * @param array<int, null|float> $value
     */
    public function setValues(array $value): self;
}
