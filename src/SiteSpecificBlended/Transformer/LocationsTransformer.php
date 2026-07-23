<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LocationsTransformer implements LocationsTransformerInterface
{
    private LocationTransformerInterface $locationTransformer;

    public function __construct(LocationTransformerInterface $locationTransformer)
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocationInterface>
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
            $locations[] = $this->locationTransformer->transform($locationData);
        }

        return $locations;
    }
}
