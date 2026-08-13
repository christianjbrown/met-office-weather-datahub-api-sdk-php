<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ReferencingTransformer implements ReferencingTransformerInterface
{
    private ReferenceSystemTransformerInterface $referenceSystemTransformer;

    public function __construct(ReferenceSystemTransformerInterface $referenceSystemTransformer)
    {
        $this->referenceSystemTransformer = $referenceSystemTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ReferenceSystemInterface>
     */
    public function transform(array $data): array
    {
        $referencing = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $referenceSystemData = $values[$i];
            if (!is_array($referenceSystemData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $referencing[] = $this->referenceSystemTransformer->transform($referenceSystemData);
        }

        return $referencing;
    }
}
