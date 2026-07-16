<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ObservationsTransformer implements ObservationsTransformerInterface
{
    private ObservationTransformerInterface $observationTransformer;

    public function __construct(ObservationTransformerInterface $observationTransformer)
    {
        $this->observationTransformer = $observationTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ObservationInterface>
     */
    public function transform(array $data): array
    {
        $observations = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $observationData = $values[$i];
            if (!is_array($observationData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $observations[] = $this->observationTransformer->transform($observationData);
        }

        return $observations;
    }
}
