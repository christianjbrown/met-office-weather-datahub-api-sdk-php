<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystem;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_keys;
use function array_values;
use function count;
use function is_array;
use function is_string;
use function sprintf;

final class ReferenceSystemTransformer implements ReferenceSystemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReferenceSystemInterface
    {
        if (!isset($data[self::KEY_COORDINATES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COORDINATES));
        }
        if (!is_array($data[self::KEY_COORDINATES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COORDINATES));
        }
        $referenceSystem = new ReferenceSystem(self::toStringArray($data[self::KEY_COORDINATES]));

        self::applyCalendar($referenceSystem, $data);
        self::applyId($referenceSystem, $data);
        self::applyIdentifiers($referenceSystem, $data);
        self::applyLabel($referenceSystem, $data);
        self::applyType($referenceSystem, $data);

        return $referenceSystem;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCalendar(ReferenceSystem $referenceSystem, array $data): void
    {
        $system = self::extractSystem($data);
        if (null === $system) {
            return;
        }
        if (empty($system[self::KEY_CALENDAR])) {
            return;
        }
        if (!is_string($system[self::KEY_CALENDAR])) {
            return;
        }
        $referenceSystem->setCalendar($system[self::KEY_CALENDAR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(ReferenceSystem $referenceSystem, array $data): void
    {
        $system = self::extractSystem($data);
        if (null === $system) {
            return;
        }
        if (empty($system[self::KEY_ID])) {
            return;
        }
        if (!is_string($system[self::KEY_ID])) {
            return;
        }
        $referenceSystem->setId($system[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIdentifiers(ReferenceSystem $referenceSystem, array $data): void
    {
        $system = self::extractSystem($data);
        if (null === $system) {
            return;
        }
        if (!isset($system[self::KEY_IDENTIFIERS])) {
            return;
        }
        if (!is_array($system[self::KEY_IDENTIFIERS])) {
            return;
        }
        $referenceSystem->setIdentifiers(self::toIdentifiers($system[self::KEY_IDENTIFIERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(ReferenceSystem $referenceSystem, array $data): void
    {
        $system = self::extractSystem($data);
        if (null === $system) {
            return;
        }
        $label = self::extractEnglishLabel($system);
        if (null === $label) {
            return;
        }
        $referenceSystem->setLabel($label);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(ReferenceSystem $referenceSystem, array $data): void
    {
        $system = self::extractSystem($data);
        if (null === $system) {
            return;
        }
        if (empty($system[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($system[self::KEY_TYPE])) {
            return;
        }
        $referenceSystem->setType($system[self::KEY_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function extractEnglishLabel(array $data): ?string
    {
        if (!isset($data[self::KEY_LABEL])) {
            return null;
        }
        if (!is_array($data[self::KEY_LABEL])) {
            return null;
        }
        $label = $data[self::KEY_LABEL];
        if (empty($label[self::KEY_EN])) {
            return null;
        }
        if (!is_string($label[self::KEY_EN])) {
            return null;
        }

        return $label[self::KEY_EN];
    }

    /**
     * @phpstan-param mixed[] $data
     *
     * @return null|mixed[]
     */
    private static function extractSystem(array $data): ?array
    {
        if (!isset($data[self::KEY_SYSTEM])) {
            return null;
        }
        if (!is_array($data[self::KEY_SYSTEM])) {
            return null;
        }

        return $data[self::KEY_SYSTEM];
    }

    private static function toIdentifierLabel(mixed $entry): ?string
    {
        if (!is_array($entry)) {
            return null;
        }

        return self::extractEnglishLabel($entry);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, string>
     */
    private static function toIdentifiers(array $data): array
    {
        $identifiers = [];
        $keys = array_keys($data);
        for ($i = 0, $count = count($keys); $i < $count; ++$i) {
            $label = self::toIdentifierLabel($data[$keys[$i]]);
            if (null === $label) {
                continue;
            }
            $identifiers[$keys[$i]] = $label;
        }

        return $identifiers;
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
