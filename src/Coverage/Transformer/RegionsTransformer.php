<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RegionInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class RegionsTransformer implements RegionsTransformerInterface
{
    private RegionTransformerInterface $regionTransformer;

    public function __construct(RegionTransformerInterface $regionTransformer)
    {
        $this->regionTransformer = $regionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RegionInterface>
     */
    public function transform(array $data): array
    {
        $regions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $regionData = $values[$i];
            if (!is_array($regionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $regions[] = $this->regionTransformer->transform($regionData);
        }

        return $regions;
    }
}
