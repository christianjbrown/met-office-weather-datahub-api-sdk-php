<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ForecastTimeStepsTransformer implements ForecastTimeStepsTransformerInterface
{
    private ForecastTimeStepTransformerInterface $forecastTimeStepTransformer;

    public function __construct(ForecastTimeStepTransformerInterface $forecastTimeStepTransformer)
    {
        $this->forecastTimeStepTransformer = $forecastTimeStepTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ForecastTimeStepInterface>
     */
    public function transform(array $data): array
    {
        $timeSteps = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $timeStepData = $values[$i];
            if (!is_array($timeStepData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $timeSteps[] = $this->forecastTimeStepTransformer->transform($timeStepData);
        }

        return $timeSteps;
    }
}
