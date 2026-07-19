<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RunInterface;

interface RunsTransformerInterface
{
    public const ARRAY_NAME = 'runs';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, RunInterface>
     */
    public function transform(array $data): array;
}
