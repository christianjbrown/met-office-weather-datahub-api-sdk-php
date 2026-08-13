<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\CollectionInterface;

interface CollectionsApiInterface extends ApiInterface
{
    public function getCollection(string $collectionId): CollectionInterface;

    /**
     * @return array<int, CollectionInterface>
     */
    public function getCollections(): array;
}
