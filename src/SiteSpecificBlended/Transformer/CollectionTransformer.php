<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Collection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;

use function array_filter;
use function array_keys;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class CollectionTransformer implements CollectionTransformerInterface
{
    private ExtentTransformerInterface $extentTransformer;
    private LinksTransformerInterface $linksTransformer;

    public function __construct(LinksTransformerInterface $linksTransformer, ExtentTransformerInterface $extentTransformer)
    {
        $this->linksTransformer = $linksTransformer;
        $this->extentTransformer = $extentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CollectionInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $collection = new Collection($data[self::KEY_ID]);

        self::applyCrs($collection, $data);
        self::applyDescription($collection, $data);
        $this->applyExtent($collection, $data);
        $this->applyLinks($collection, $data);
        self::applyOutputFormats($collection, $data);
        self::applyParameterNames($collection, $data);
        self::applyTitle($collection, $data);

        return $collection;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCrs(Collection $collection, array $data): void
    {
        if (!isset($data[self::KEY_CRS])) {
            return;
        }
        if (!is_array($data[self::KEY_CRS])) {
            return;
        }
        $collection->setCrs(self::toStringArray($data[self::KEY_CRS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Collection $collection, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $collection->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyExtent(Collection $collection, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $collection->setExtent($this->extentTransformer->transform($data[self::KEY_EXTENT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLinks(Collection $collection, array $data): void
    {
        if (!isset($data[self::KEY_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINKS])) {
            return;
        }
        $collection->setLinks($this->linksTransformer->transform($data[self::KEY_LINKS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOutputFormats(Collection $collection, array $data): void
    {
        if (!isset($data[self::KEY_OUTPUT_FORMATS])) {
            return;
        }
        if (!is_array($data[self::KEY_OUTPUT_FORMATS])) {
            return;
        }
        $collection->setOutputFormats(self::toStringArray($data[self::KEY_OUTPUT_FORMATS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyParameterNames(Collection $collection, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETER_NAMES])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETER_NAMES])) {
            return;
        }
        $collection->setParameterNames(self::toStringArray(array_keys($data[self::KEY_PARAMETER_NAMES])));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(Collection $collection, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $collection->setTitle($data[self::KEY_TITLE]);
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
