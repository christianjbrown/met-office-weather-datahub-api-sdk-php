<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CollectionsTransformer implements CollectionsTransformerInterface
{
    private CollectionTransformerInterface $collectionTransformer;

    public function __construct(CollectionTransformerInterface $collectionTransformer)
    {
        $this->collectionTransformer = $collectionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CollectionInterface>
     */
    public function transform(array $data): array
    {
        $collections = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $collectionData = $values[$i];
            if (!is_array($collectionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $collections[] = $this->collectionTransformer->transform($collectionData);
        }

        return $collections;
    }
}
