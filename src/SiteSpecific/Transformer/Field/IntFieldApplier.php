<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use Closure;

use function is_int;

/**
 * Applies an integer field when the payload value is an integer.
 */
final class IntFieldApplier implements DailyForecastFieldApplierInterface
{
    private string $key;

    /**
     * @var Closure(DailyForecastTimeStepInterface, int): mixed
     */
    private Closure $setter;

    /**
     * @phpstan-param Closure(DailyForecastTimeStepInterface, int): mixed $setter
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
        ($this->setter)($timeStep, $data[$this->key]);
    }
}
