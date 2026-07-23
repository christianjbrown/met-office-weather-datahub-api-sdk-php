<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionsTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformerInterface;

use function is_array;
use function sprintf;

final class CollectionsApi implements CollectionsApiInterface
{
    private ApiKeyInterface $apiKey;
    private CollectionsTransformerInterface $collectionsTransformer;
    private CollectionTransformerInterface $collectionTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, CollectionsTransformerInterface $collectionsTransformer, CollectionTransformerInterface $collectionTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->collectionsTransformer = $collectionsTransformer;
        $this->collectionTransformer = $collectionTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getCollection(string $collectionId): CollectionInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_COLLECTION_SPRINTF, $collectionId), [], $headers);

        return $this->collectionTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CollectionInterface>
     */
    public function getCollections(): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(self::API_URL_COLLECTIONS, [], $headers);

        return $this->collectionsTransformer->transform(self::extractCollections($data));
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractCollections(array $data): array
    {
        if (!isset($data[self::KEY_COLLECTIONS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COLLECTIONS));
        }
        if (!is_array($data[self::KEY_COLLECTIONS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COLLECTIONS));
        }

        return $data[self::KEY_COLLECTIONS];
    }
}
