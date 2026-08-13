<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\ApiInterface;

use function implode;

final class DataQuery implements DataQueryInterface
{
    private ?string $datetime;

    /**
     * @var array<int, string>
     */
    private array $parameterNames;

    /**
     * @var array<int, string>
     */
    private array $percentiles;

    /**
     * @param array<int, string> $parameterNames
     * @param array<int, string> $percentiles
     */
    public function __construct(array $parameterNames = [], array $percentiles = [], ?string $datetime = null)
    {
        $this->parameterNames = $parameterNames;
        $this->percentiles = $percentiles;
        $this->datetime = $datetime;
    }

    public function getDatetime(): ?string
    {
        return $this->datetime;
    }

    /**
     * @return array<int, string>
     */
    public function getParameterNames(): array
    {
        return $this->parameterNames;
    }

    /**
     * @return array<int, string>
     */
    public function getPercentiles(): array
    {
        return $this->percentiles;
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        $query = [];
        if ([] !== $this->parameterNames) {
            $query[ApiInterface::QUERY_KEY_PARAMETER_NAME] = implode(self::QUERY_SEPARATOR, $this->parameterNames);
        }
        if ([] !== $this->percentiles) {
            $query[ApiInterface::QUERY_KEY_PERCENTILES] = implode(self::QUERY_SEPARATOR, $this->percentiles);
        }
        if (null !== $this->datetime) {
            $query[ApiInterface::QUERY_KEY_DATETIME] = $this->datetime;
        }

        return $query;
    }
}
