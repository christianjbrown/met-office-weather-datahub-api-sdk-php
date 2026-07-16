<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\Forecast;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

use function is_array;
use function is_string;
use function strtotime;

final class ForecastTransformer implements ForecastTransformerInterface
{
    private ForecastTimeStepsTransformerInterface $forecastTimeStepsTransformer;

    public function __construct(ForecastTimeStepsTransformerInterface $forecastTimeStepsTransformer)
    {
        $this->forecastTimeStepsTransformer = $forecastTimeStepsTransformer;
    }

    /**
     * @param mixed[] $properties
     */
    public function transform(array $properties): ForecastInterface
    {
        $forecast = new Forecast();

        $this->applyLocationName($forecast, $properties);
        $this->applyModelRunDate($forecast, $properties);
        $this->applyTimeSteps($forecast, $properties);

        return $forecast;
    }

    private function applyLocationName(Forecast $forecast, array $data): void
    {
        if (empty($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $location = $data[self::KEY_LOCATION];
        if (empty($location[self::KEY_NAME])) {
            return;
        }
        if (!is_string($location[self::KEY_NAME])) {
            return;
        }
        $forecast->setLocationName($location[self::KEY_NAME]);
    }

    private function applyModelRunDate(Forecast $forecast, array $data): void
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
}
