<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class NearestLocationsTransformer implements NearestLocationsTransformerInterface
{
    private NearestLocationTransformerInterface $nearestLocationTransformer;

    public function __construct(NearestLocationTransformerInterface $nearestLocationTransformer)
    {
        $this->nearestLocationTransformer = $nearestLocationTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, NearestLocationInterface>
     */
    public function transform(array $data): array
    {
        $locations = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $locationData = $values[$i];
            if (!is_array($locationData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $locations[] = $this->nearestLocationTransformer->transform($locationData);
        }

        return $locations;
    }
}
