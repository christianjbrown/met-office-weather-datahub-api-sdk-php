<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\MetOffice\Coverage\Model\RunInterface;

interface RunsApiInterface extends ApiInterface
{
    /**
     * @return array<int, RunInterface>
     */
    public function getRuns(?string $sort = null): array;

    /**
     * @return array<int, RunInterface>
     */
    public function getRunsByModel(string $modelId, ?string $sort = null): array;
}
