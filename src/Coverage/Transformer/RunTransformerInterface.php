<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RunInterface;

interface RunTransformerInterface
{
    public const string KEY_COMPLETE_RUNS = 'completeRuns';
    public const string KEY_MODEL_ID = 'modelId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunInterface;
}
