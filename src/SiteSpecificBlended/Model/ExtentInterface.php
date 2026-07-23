<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

interface ExtentInterface
{
    /**
     * @return array<int, float>
     */
    public function getSpatialBbox(): array;

    public function getSpatialCrs(): ?string;

    /**
     * @return array<int, string>
     */
    public function getTemporalInterval(): array;

    /**
     * @return array<int, string>
     */
    public function getTemporalValues(): array;

    /**
     * @return array<int, float>
     */
    public function getVerticalValues(): array;

    /**
     * @param array<int, float> $value
     */
    public function setSpatialBbox(array $value): self;

    public function setSpatialCrs(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setTemporalInterval(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setTemporalValues(array $value): self;

    /**
     * @param array<int, float> $value
     */
    public function setVerticalValues(array $value): self;
}
