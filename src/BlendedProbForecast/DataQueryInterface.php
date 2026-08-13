<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

interface DataQueryInterface
{
    public const string QUERY_SEPARATOR = ',';

    public function getDatetime(): ?string;

    /**
     * @return array<int, string>
     */
    public function getParameterNames(): array;

    /**
     * @return array<int, string>
     */
    public function getPercentiles(): array;

    /**
     * @return array<string, string>
     */
    public function toQuery(): array;
}
