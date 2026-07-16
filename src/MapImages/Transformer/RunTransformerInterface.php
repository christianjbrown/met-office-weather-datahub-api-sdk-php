<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\RunInterface;

interface RunTransformerInterface
{
    public const KEY_COMPLETE_RUNS = 'completeRuns';
    public const KEY_MODEL_ID = 'modelId';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunInterface;
}
