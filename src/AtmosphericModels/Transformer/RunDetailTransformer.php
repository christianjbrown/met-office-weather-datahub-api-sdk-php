<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RunDetail;
use ChristianBrown\MetOffice\AtmosphericModels\Model\RunDetailInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_string;
use function sprintf;
use function strtotime;

final class RunDetailTransformer implements RunDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunDetailInterface
    {
        if (empty($data[self::KEY_RUN_DATE_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_RUN_DATE_TIME));
        }
        if (!is_string($data[self::KEY_RUN_DATE_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_RUN_DATE_TIME));
        }
        $runDateTime = strtotime($data[self::KEY_RUN_DATE_TIME]);
        if (false === $runDateTime) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_TIMESTAMP_SPRINTF, $data[self::KEY_RUN_DATE_TIME]));
        }
        $runDetail = new RunDetail($runDateTime);

        $this->applyRun($runDetail, $data);
        $this->applyRunFilter($runDetail, $data);

        return $runDetail;
    }

    private function applyRun(RunDetail $runDetail, array $data): void
    {
        if (empty($data[self::KEY_RUN])) {
            return;
        }
        if (!is_string($data[self::KEY_RUN])) {
            return;
        }
        $runDetail->setRun($data[self::KEY_RUN]);
    }

    private function applyRunFilter(RunDetail $runDetail, array $data): void
    {
        if (empty($data[self::KEY_RUN_FILTER])) {
            return;
        }
        if (!is_string($data[self::KEY_RUN_FILTER])) {
            return;
        }
        $runDetail->setRunFilter($data[self::KEY_RUN_FILTER]);
    }
}
