<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use Closure;

use function is_int;

/**
 * Applies a significant weather code field when the payload value is a known WeatherType code.
 */
final class WeatherTypeFieldApplier implements DailyForecastFieldApplierInterface
{
    private string $key;

    /**
     * @var Closure(DailyForecastTimeStepInterface, WeatherType): mixed
     */
    private Closure $setter;

    /**
     * @phpstan-param Closure(DailyForecastTimeStepInterface, WeatherType): mixed $setter
     */
    public function __construct(string $key, Closure $setter)
    {
        $this->key = $key;
        $this->setter = $setter;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(DailyForecastTimeStepInterface $timeStep, array $data): void
    {
        if (!isset($data[$this->key])) {
            return;
        }
        if (!is_int($data[$this->key])) {
            return;
        }
        $weatherType = WeatherType::tryFrom($data[$this->key]);
        if (null === $weatherType) {
            return;
        }
        ($this->setter)($timeStep, $weatherType);
    }
}
