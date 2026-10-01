<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStep;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\DailyForecastFieldApplierInterface;

use function array_map;
use function is_string;
use function sprintf;
use function strtotime;

/**
 * Reads the mandatory time of a daily time step, then hands the payload to
 * each injected field applier in turn.
 */
final class DailyForecastTimeStepTransformer implements DailyForecastTimeStepTransformerInterface
{
    /**
     * @var DailyForecastFieldApplierInterface[]
     */
    private array $appliers;

    /**
     * @param DailyForecastFieldApplierInterface[] $appliers
     */
    public function __construct(array $appliers)
    {
        $this->appliers = $appliers;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DailyForecastTimeStepInterface
    {
        if (empty($data[self::KEY_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME));
        }
        if (!is_string($data[self::KEY_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME));
        }
        $time = strtotime($data[self::KEY_TIME]);
        if (false === $time) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_TIMESTAMP_SPRINTF, $data[self::KEY_TIME]));
        }
        $timeStep = new DailyForecastTimeStep($time);
        array_map(static function (DailyForecastFieldApplierInterface $applier) use ($timeStep, $data): bool {
            $applier->apply($timeStep, $data);

            return true;
        }, $this->appliers);

        return $timeStep;
    }
}
