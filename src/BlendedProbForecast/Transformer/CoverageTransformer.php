<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Coverage;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function is_string;
use function sprintf;

final class CoverageTransformer implements CoverageTransformerInterface
{
    private DomainTransformerInterface $domainTransformer;
    private ParametersTransformerInterface $parametersTransformer;
    private RangesTransformerInterface $rangesTransformer;

    public function __construct(DomainTransformerInterface $domainTransformer, ParametersTransformerInterface $parametersTransformer, RangesTransformerInterface $rangesTransformer)
    {
        $this->domainTransformer = $domainTransformer;
        $this->parametersTransformer = $parametersTransformer;
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

        self::applyId($coverage, $data);
        $this->applyParameters($coverage, $data);
        $this->applyRanges($coverage, $data);

        return $coverage;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(Coverage $coverage, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $coverage->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameters(Coverage $coverage, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETERS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETERS])) {
            return;
        }
        $coverage->setParameters($this->parametersTransformer->transform($data[self::KEY_PARAMETERS]));
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
