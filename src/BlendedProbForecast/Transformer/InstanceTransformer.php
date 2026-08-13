<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Instance;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_keys;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class InstanceTransformer implements InstanceTransformerInterface
{
    private ExtentTransformerInterface $extentTransformer;
    private LinksTransformerInterface $linksTransformer;
    private ParametersTransformerInterface $parametersTransformer;

    public function __construct(LinksTransformerInterface $linksTransformer, ExtentTransformerInterface $extentTransformer, ParametersTransformerInterface $parametersTransformer)
    {
        $this->linksTransformer = $linksTransformer;
        $this->extentTransformer = $extentTransformer;
        $this->parametersTransformer = $parametersTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstanceInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $instance = new Instance($data[self::KEY_ID]);

        self::applyCrs($instance, $data);
        self::applyDataQueries($instance, $data);
        $this->applyExtent($instance, $data);
        $this->applyLinks($instance, $data);
        self::applyOutputFormats($instance, $data);
        $this->applyParameters($instance, $data);

        return $instance;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCrs(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_CRS])) {
            return;
        }
        if (!is_array($data[self::KEY_CRS])) {
            return;
        }
        $instance->setCrs(self::toStringArray($data[self::KEY_CRS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDataQueries(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_DATA_QUERIES])) {
            return;
        }
        if (!is_array($data[self::KEY_DATA_QUERIES])) {
            return;
        }
        $instance->setDataQueries(self::toStringArray(array_keys($data[self::KEY_DATA_QUERIES])));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyExtent(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $instance->setExtent($this->extentTransformer->transform($data[self::KEY_EXTENT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLinks(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINKS])) {
            return;
        }
        $instance->setLinks($this->linksTransformer->transform($data[self::KEY_LINKS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOutputFormats(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_OUTPUT_FORMATS])) {
            return;
        }
        if (!is_array($data[self::KEY_OUTPUT_FORMATS])) {
            return;
        }
        $instance->setOutputFormats(self::toStringArray($data[self::KEY_OUTPUT_FORMATS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameters(Instance $instance, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETER_NAMES])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETER_NAMES])) {
            return;
        }
        $instance->setParameters($this->parametersTransformer->transform($data[self::KEY_PARAMETER_NAMES]));
    }

    /**
     * @param mixed[] $values
     *
     * @return array<int, string>
     */
    private static function toStringArray(array $values): array
    {
        return array_values(array_filter($values, static fn (mixed $value): bool => is_string($value)));
    }
}
