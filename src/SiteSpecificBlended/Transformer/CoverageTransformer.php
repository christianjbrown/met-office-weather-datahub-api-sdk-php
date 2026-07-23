<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Coverage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;

use function is_array;
use function sprintf;

final class CoverageTransformer implements CoverageTransformerInterface
{
    private DomainTransformerInterface $domainTransformer;
    private RangesTransformerInterface $rangesTransformer;

    public function __construct(DomainTransformerInterface $domainTransformer, RangesTransformerInterface $rangesTransformer)
    {
        $this->domainTransformer = $domainTransformer;
        $this->rangesTransformer = $rangesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CoverageInterface
    {
        if (!isset($data[self::KEY_DOMAIN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_DOMAIN));
        }
        if (!is_array($data[self::KEY_DOMAIN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_DOMAIN));
        }
        $coverage = new Coverage($this->domainTransformer->transform($data[self::KEY_DOMAIN]));

        $this->applyRanges($coverage, $data);

        return $coverage;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRanges(Coverage $coverage, array $data): void
    {
        if (!isset($data[self::KEY_RANGES])) {
            return;
        }
        if (!is_array($data[self::KEY_RANGES])) {
            return;
        }
        $coverage->setRanges($this->rangesTransformer->transform($data[self::KEY_RANGES]));
    }
}
