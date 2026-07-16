<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RunInterface;

interface RunsApiInterface extends ApiInterface
{
    /**
     * @return array<int, RunInterface>
     */
    public function getRuns(): array;

    /**
     * @return array<int, RunInterface>
     */
    public function getRunsByModel(string $modelId): array;
}
