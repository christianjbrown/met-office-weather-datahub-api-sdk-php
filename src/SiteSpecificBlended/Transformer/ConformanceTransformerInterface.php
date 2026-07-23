<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

interface ConformanceTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array;
}
