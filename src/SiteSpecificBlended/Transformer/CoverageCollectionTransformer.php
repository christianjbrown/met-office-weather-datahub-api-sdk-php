<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollectionInterface;

use function is_array;
use function is_string;

final class CoverageCollectionTransformer implements CoverageCollectionTransformerInterface
{
    private CoveragesTransformerInterface $coveragesTransformer;
    private ParametersTransformerInterface $parametersTransformer;

    public function __construct(ParametersTransformerInterface $parametersTransformer, CoveragesTransformerInterface $coveragesTransformer)
    {
        $this->parametersTransformer = $parametersTransformer;
        $this->coveragesTransformer = $coveragesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CoverageCollectionInterface
    {
        $coverageCollection = new CoverageCollection();

        $this->applyCoverages($coverageCollection, $data);
        self::applyDomainType($coverageCollection, $data);
        $this->applyParameters($coverageCollection, $data);

        return $coverageCollection;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCoverages(CoverageCollection $coverageCollection, array $data): void
    {
        if (!isset($data[self::KEY_COVERAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_COVERAGES])) {
            return;
        }
        $coverageCollection->setCoverages($this->coveragesTransformer->transform($data[self::KEY_COVERAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDomainType(CoverageCollection $coverageCollection, array $data): void
    {
        if (empty($data[self::KEY_DOMAIN_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_DOMAIN_TYPE])) {
            return;
        }
        $coverageCollection->setDomainType($data[self::KEY_DOMAIN_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameters(CoverageCollection $coverageCollection, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETERS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETERS])) {
            return;
        }
        $coverageCollection->setParameters($this->parametersTransformer->transform($data[self::KEY_PARAMETERS]));
    }
}
