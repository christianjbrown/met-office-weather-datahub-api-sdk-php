<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

interface RunInterface
{
    /**
     * @return array<int, RunDetailInterface>
     */
    public function getCompleteRuns(): array;

    public function getModelId(): string;

    /**
     * @param array<int, RunDetailInterface> $value
     */
    public function setCompleteRuns(array $value): self;

    public function setModelId(string $value): self;
}
