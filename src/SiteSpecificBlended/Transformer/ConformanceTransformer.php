<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use function array_filter;
use function array_values;
use function is_string;

final class ConformanceTransformer implements ConformanceTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array
    {
        return array_values(array_filter($data, static fn (mixed $value): bool => is_string($value)));
    }
}
