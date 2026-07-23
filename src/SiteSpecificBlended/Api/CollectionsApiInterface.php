<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;

interface CollectionsApiInterface extends ApiInterface
{
    public function getCollection(string $collectionId): CollectionInterface;

    /**
     * @return array<int, CollectionInterface>
     */
    public function getCollections(): array;
}
