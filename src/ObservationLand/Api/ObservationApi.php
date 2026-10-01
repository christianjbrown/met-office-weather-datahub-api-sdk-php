<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformerInterface;

use function sprintf;

final class ObservationApi implements ObservationApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiKeyInterface $apiKey;

    /**
     * @var array<string, array<int, ObservationInterface>>
     */
    private array $cache = [];
    private ObservationsTransformerInterface $observationsTransformer;
    private JsonReadApiRequestSenderInterface $requestSender;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, ObservationsTransformerInterface $observationsTransformer, ApiKeyInterface $apiKey, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->observationsTransformer = $observationsTransformer;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ObservationInterface>
     *
     * @phpstan-impure
     */
    public function getByGeohash(string $geohash, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->cache[$geohash])) {
                return $this->cache[$geohash];
            }
        }

        $headers = $this->apiKey->toHeaders();
        $data = $this->requestSender->get($this->apiHost->rewrite(sprintf(self::API_URL_OBSERVATION_SPRINTF, $geohash)), [], $headers);

        $observations = $this->observationsTransformer->transform($data);
        $this->cache[$geohash] = $observations;

        return $observations;
    }
}
