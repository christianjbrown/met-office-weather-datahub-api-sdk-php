<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

final class Run implements RunInterface
{
    /**
     * @var array<int, RunDetailInterface>
     */
    private array $completeRuns = [];
    private string $modelId;

    public function __construct(string $modelId)
    {
        $this->modelId = $modelId;
    }

    /**
     * @return array<int, RunDetailInterface>
     */
    public function getCompleteRuns(): array
    {
        return $this->completeRuns;
    }

    public function getModelId(): string
    {
        return $this->modelId;
    }

    /**
     * @param array<int, RunDetailInterface> $value
     */
    public function setCompleteRuns(array $value): RunInterface
    {
        $this->completeRuns = $value;

        return $this;
    }

    public function setModelId(string $value): RunInterface
    {
        $this->modelId = $value;

        return $this;
    }
}
