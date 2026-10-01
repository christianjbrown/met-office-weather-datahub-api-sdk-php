<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use Closure;

use function is_float;
use function is_int;

/**
 * Applies a float field when the payload value is a float or an integer.
 */
final class FloatFieldApplier implements DailyForecastFieldApplierInterface
{
    private string $key;

    /**
     * @var Closure(DailyForecastTimeStepInterface, float): mixed
     */
    private Closure $setter;

    /**
     * @phpstan-param Closure(DailyForecastTimeStepInterface, float): mixed $setter
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
        $value = $data[$this->key];
        if (is_int($value)) {
            ($this->setter)($timeStep, (float) $value);

            return;
        }
        if (is_float($value)) {
            ($this->setter)($timeStep, $value);
        }
    }
}
