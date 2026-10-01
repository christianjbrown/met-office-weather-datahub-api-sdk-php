<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\CoordinatesInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;

use function rawurlencode;
use function sprintf;

final class PositionApi implements PositionApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiKeyInterface $apiKey;
    private CoverageCollectionTransformerInterface $coverageCollectionTransformer;
    private JsonReadApiRequestSenderInterface $requestSender;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, CoverageCollectionTransformerInterface $coverageCollectionTransformer, ApiKeyInterface $apiKey, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->coverageCollectionTransformer = $coverageCollectionTransformer;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getPosition(string $collectionId, string $instanceId, CoordinatesInterface $coordinates, ?DataQueryInterface $query = null): CoverageCollectionInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get($this->apiHost->rewrite(sprintf(self::API_URL_POSITION_SPRINTF, $collectionId, rawurlencode($instanceId))), self::buildQuery($coordinates, $query), $headers);

        return $this->coverageCollectionTransformer->transform($data);
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(CoordinatesInterface $coordinates, ?DataQueryInterface $query): array
    {
        $built = [
            self::QUERY_KEY_COORDS => self::toPoint($coordinates),
        ];
        if (null === $query) {
            return $built;
        }

        return [...$built, ...$query->toQuery()];
    }

    private static function toPoint(CoordinatesInterface $coordinates): string
    {
        return sprintf(self::COORDS_POINT_SPRINTF, (string) $coordinates->getLongitude(), (string) $coordinates->getLatitude());
    }
}
