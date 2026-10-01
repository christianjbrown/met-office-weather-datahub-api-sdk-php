<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LandingPageInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ConformanceTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LandingPageTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHostInterface;

use function is_array;
use function sprintf;

final class CapabilitiesApi implements CapabilitiesApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiKeyInterface $apiKey;
    private ConformanceTransformerInterface $conformanceTransformer;
    private LandingPageTransformerInterface $landingPageTransformer;
    private JsonReadApiRequestSenderInterface $requestSender;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, LandingPageTransformerInterface $landingPageTransformer, ConformanceTransformerInterface $conformanceTransformer, ApiKeyInterface $apiKey, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->landingPageTransformer = $landingPageTransformer;
        $this->conformanceTransformer = $conformanceTransformer;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, string>
     */
    public function getConformance(): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get($this->apiHost->rewrite(self::API_URL_CONFORMANCE), [], $headers);

        return $this->conformanceTransformer->transform(self::extractConformsTo($data));
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getLandingPage(): LandingPageInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get($this->apiHost->rewrite(self::API_URL_LANDING_PAGE), [], $headers);

        return $this->landingPageTransformer->transform($data);
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractConformsTo(array $data): array
    {
        if (!isset($data[self::KEY_CONFORMS_TO])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_CONFORMS_TO));
        }
        if (!is_array($data[self::KEY_CONFORMS_TO])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_CONFORMS_TO));
        }

        return $data[self::KEY_CONFORMS_TO];
    }
}
