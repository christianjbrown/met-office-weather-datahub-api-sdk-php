<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\RunDetailInterface;

interface RunDetailsTransformerInterface
{
    public const ARRAY_NAME = 'completeRuns';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, RunDetailInterface>
     */
    public function transform(array $data): array;
}
