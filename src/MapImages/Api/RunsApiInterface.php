<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Api;

use ChristianBrown\MetOffice\MapImages\Model\RunInterface;

interface RunsApiInterface extends ApiInterface
{
    /**
     * @return array<int, RunInterface>
     */
    public function getRuns(): array;
}
