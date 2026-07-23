<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArrayInterface;

use function array_keys;
use function count;
use function is_array;
use function sprintf;

final class RangesTransformer implements RangesTransformerInterface
{
    private RangeTransformerInterface $rangeTransformer;

    public function __construct(RangeTransformerInterface $rangeTransformer)
    {
        $this->rangeTransformer = $rangeTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<string, NdArrayInterface>
     */
    public function transform(array $data): array
    {
        $ranges = [];
        $keys = array_keys($data);
        for ($i = 0, $count = count($keys); $i < $count; ++$i) {
            $key = (string) $keys[$i];
            $rangeData = $data[$keys[$i]];
            if (!is_array($rangeData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $rangeData[RangeTransformerInterface::KEY_ID] = $key;
            $ranges[$key] = $this->rangeTransformer->transform($rangeData);
        }

        return $ranges;
    }
}
