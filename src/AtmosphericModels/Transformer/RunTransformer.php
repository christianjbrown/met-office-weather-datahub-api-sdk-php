<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\Run;
use ChristianBrown\MetOffice\AtmosphericModels\Model\RunInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function is_string;
use function sprintf;

final class RunTransformer implements RunTransformerInterface
{
    private RunDetailsTransformerInterface $runDetailsTransformer;

    public function __construct(RunDetailsTransformerInterface $runDetailsTransformer)
    {
        $this->runDetailsTransformer = $runDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunInterface
    {
        if (empty($data[self::KEY_MODEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MODEL_ID));
        }
        if (!is_string($data[self::KEY_MODEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MODEL_ID));
        }
        $run = new Run($data[self::KEY_MODEL_ID]);

        $this->applyCompleteRuns($run, $data);

        return $run;
    }

    private function applyCompleteRuns(Run $run, array $data): void
    {
        if (!isset($data[self::KEY_COMPLETE_RUNS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPLETE_RUNS])) {
            return;
        }
        $run->setCompleteRuns($this->runDetailsTransformer->transform($data[self::KEY_COMPLETE_RUNS]));
    }
}
