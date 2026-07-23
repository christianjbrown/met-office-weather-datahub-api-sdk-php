<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFile;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;
use function strtotime;

final class OrderFileTransformer implements OrderFileTransformerInterface
{
    private RegionTransformerInterface $regionTransformer;

    public function __construct(RegionTransformerInterface $regionTransformer)
    {
        $this->regionTransformer = $regionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileInterface
    {
        if (empty($data[self::KEY_FILE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_FILE_ID));
        }
        if (!is_string($data[self::KEY_FILE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_FILE_ID));
        }
        $orderFile = new OrderFile($data[self::KEY_FILE_ID]);

        self::applyLevels($orderFile, $data);
        self::applyParameters($orderFile, $data);
        $this->applyRegion($orderFile, $data);
        self::applyRun($orderFile, $data);
        self::applyRunDateTime($orderFile, $data);
        self::applySurfaceId($orderFile, $data);
        self::applyTimesteps($orderFile, $data);

        return $orderFile;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLevels(OrderFile $orderFile, array $data): void
    {
        if (!isset($data[self::KEY_LEVELS])) {
            return;
        }
        if (!is_array($data[self::KEY_LEVELS])) {
            return;
        }
        $orderFile->setLevels(self::toStringArray($data[self::KEY_LEVELS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyParameters(OrderFile $orderFile, array $data): void
    {
        if (!isset($data[self::KEY_PARAMETERS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETERS])) {
            return;
        }
        $orderFile->setParameters(self::toStringArray($data[self::KEY_PARAMETERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegion(OrderFile $orderFile, array $data): void
    {
        if (!isset($data[self::KEY_REGION])) {
            return;
        }
        if (!is_array($data[self::KEY_REGION])) {
            return;
        }
        $orderFile->setRegion($this->regionTransformer->transform($data[self::KEY_REGION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRun(OrderFile $orderFile, array $data): void
    {
        if (empty($data[self::KEY_RUN])) {
            return;
        }
        if (!is_string($data[self::KEY_RUN])) {
            return;
        }
        $orderFile->setRun($data[self::KEY_RUN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRunDateTime(OrderFile $orderFile, array $data): void
    {
        if (empty($data[self::KEY_RUN_DATE_TIME])) {
            return;
        }
        if (!is_string($data[self::KEY_RUN_DATE_TIME])) {
            return;
        }
        $runDateTime = strtotime($data[self::KEY_RUN_DATE_TIME]);
        if (false === $runDateTime) {
            return;
        }
        $orderFile->setRunDateTime($runDateTime);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySurfaceId(OrderFile $orderFile, array $data): void
    {
        if (empty($data[self::KEY_SURFACE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SURFACE_ID])) {
            return;
        }
        $orderFile->setSurfaceId($data[self::KEY_SURFACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimesteps(OrderFile $orderFile, array $data): void
    {
        if (!isset($data[self::KEY_TIMESTEPS])) {
            return;
        }
        if (!is_array($data[self::KEY_TIMESTEPS])) {
            return;
        }
        $orderFile->setTimesteps(self::toStringArray($data[self::KEY_TIMESTEPS]));
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
