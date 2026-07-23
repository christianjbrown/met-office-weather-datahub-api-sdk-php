<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CoveragesTransformer implements CoveragesTransformerInterface
{
    private CoverageTransformerInterface $coverageTransformer;

    public function __construct(CoverageTransformerInterface $coverageTransformer)
    {
        $this->coverageTransformer = $coverageTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CoverageInterface>
     */
    public function transform(array $data): array
    {
        $coverages = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $coverageData = $values[$i];
            if (!is_array($coverageData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $coverages[] = $this->coverageTransformer->transform($coverageData);
        }

        return $coverages;
    }
}
