<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\Forecast;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadataInterface;

use function array_keys;
use function array_values;
use function count;
use function is_array;
use function is_float;
use function is_int;
use function is_numeric;
use function is_string;
use function strtotime;

final class ForecastTransformer implements ForecastTransformerInterface
{
    private ForecastTimeStepsTransformerInterface $forecastTimeStepsTransformer;
    private ?ParameterMetadataTransformerInterface $parameterMetadataTransformer;

    public function __construct(ForecastTimeStepsTransformerInterface $forecastTimeStepsTransformer, ?ParameterMetadataTransformerInterface $parameterMetadataTransformer = null)
    {
        $this->forecastTimeStepsTransformer = $forecastTimeStepsTransformer;
        $this->parameterMetadataTransformer = $parameterMetadataTransformer;
    }

    /**
     * @param mixed[] $properties
     */
    public function transform(array $properties): ForecastInterface
    {
        $forecast = new Forecast();

        self::applyElevation($forecast, $properties);
        self::applyLocation($forecast, $properties);
        self::applyModelRunDate($forecast, $properties);
        $this->applyParameters($forecast, $properties);
        self::applyRequestPointDistance($forecast, $properties);
        $this->applyTimeSteps($forecast, $properties);

        return $forecast;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyElevation(Forecast $forecast, array $data): void
    {
        if (empty($data[self::KEY_GEOMETRY])) {
            return;
        }
        if (!is_array($data[self::KEY_GEOMETRY])) {
            return;
        }
        $geometry = $data[self::KEY_GEOMETRY];
        if (empty($geometry[self::KEY_COORDINATES])) {
            return;
        }
        if (!is_array($geometry[self::KEY_COORDINATES])) {
            return;
        }
        $coordinates = array_values($geometry[self::KEY_COORDINATES]);
        if (!isset($coordinates[2])) {
            return;
        }
        if (!is_numeric($coordinates[2])) {
            return;
        }
        $forecast->setElevation((float) $coordinates[2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocation(Forecast $forecast, array $data): void
    {
        if (empty($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $location = $data[self::KEY_LOCATION];
        self::applyLocationName($forecast, $location);
        self::applyLocationLicence($forecast, $location);
    }

    /**
     * @phpstan-param mixed[] $location
     */
    private static function applyLocationLicence(Forecast $forecast, array $location): void
    {
        if (empty($location[self::KEY_LICENCE])) {
            return;
        }
        if (!is_string($location[self::KEY_LICENCE])) {
            return;
        }
        $forecast->setLocationLicence($location[self::KEY_LICENCE]);
    }

    /**
     * @phpstan-param mixed[] $location
     */
    private static function applyLocationName(Forecast $forecast, array $location): void
    {
        if (empty($location[self::KEY_NAME])) {
            return;
        }
        if (!is_string($location[self::KEY_NAME])) {
            return;
        }
        $forecast->setLocationName($location[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModelRunDate(Forecast $forecast, array $data): void
    {
        if (empty($data[self::KEY_MODEL_RUN_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MODEL_RUN_DATE])) {
            return;
        }
        $modelRunDate = strtotime($data[self::KEY_MODEL_RUN_DATE]);
        if (false === $modelRunDate) {
            return;
        }
        $forecast->setModelRunDate($modelRunDate);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameters(Forecast $forecast, array $data): void
    {
        if (null === $this->parameterMetadataTransformer) {
            return;
        }
        if (!isset($data[self::KEY_PARAMETERS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETERS])) {
            return;
        }
        $groups = array_values($data[self::KEY_PARAMETERS]);
        $parameters = [];
        for ($i = 0, $count = count($groups); $i < $count; ++$i) {
            $parameters = self::mergeParameterGroup($parameters, $groups[$i], $this->parameterMetadataTransformer);
        }
        $forecast->setParameters($parameters);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRequestPointDistance(Forecast $forecast, array $data): void
    {
        if (!isset($data[self::KEY_REQUEST_POINT_DISTANCE])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_REQUEST_POINT_DISTANCE]);
        if (null === $value) {
            return;
        }
        $forecast->setRequestPointDistance($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTimeSteps(Forecast $forecast, array $data): void
    {
        if (empty($data[self::KEY_TIME_SERIES])) {
            return;
        }
        if (!is_array($data[self::KEY_TIME_SERIES])) {
            return;
        }
        $timeSteps = $this->forecastTimeStepsTransformer->transform($data[self::KEY_TIME_SERIES]);
        $forecast->setTimeSteps($timeSteps);
    }

    /**
     * @param array<array-key, ParameterMetadataInterface> $parameters
     *
     * @return array<array-key, ParameterMetadataInterface>
     */
    private static function mergeParameterGroup(array $parameters, mixed $group, ParameterMetadataTransformerInterface $transformer): array
    {
        if (!is_array($group)) {
            return $parameters;
        }
        $names = array_keys($group);
        for ($i = 0, $count = count($names); $i < $count; ++$i) {
            $parameters = self::mergeParameterGroupEntry($parameters, $group, $names[$i], $transformer);
        }

        return $parameters;
    }

    /**
     * @param array<array-key, ParameterMetadataInterface> $parameters
     * @param array<array-key, mixed>                      $group
     *
     * @return array<array-key, ParameterMetadataInterface>
     */
    private static function mergeParameterGroupEntry(array $parameters, array $group, int|string $name, ParameterMetadataTransformerInterface $transformer): array
    {
        if (!is_array($group[$name])) {
            return $parameters;
        }
        $parameters[$name] = $transformer->transform($group[$name]);

        return $parameters;
    }

    private static function toFloat(mixed $value): ?float
    {
        if (is_int($value)) {
            return (float) $value;
        }
        if (is_float($value)) {
            return $value;
        }

        return null;
    }
}
