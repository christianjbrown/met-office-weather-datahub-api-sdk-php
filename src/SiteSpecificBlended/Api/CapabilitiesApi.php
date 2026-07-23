<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPageInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ConformanceTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformerInterface;

use function is_array;
use function sprintf;

final class CapabilitiesApi implements CapabilitiesApiInterface
{
    private ApiKeyInterface $apiKey;
    private ConformanceTransformerInterface $conformanceTransformer;
    private LandingPageTransformerInterface $landingPageTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LandingPageTransformerInterface $landingPageTransformer, ConformanceTransformerInterface $conformanceTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->landingPageTransformer = $landingPageTransformer;
        $this->conformanceTransformer = $conformanceTransformer;
        $this->apiKey = $apiKey;
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
        $data = $this->requestSender->get(self::API_URL_CONFORMANCE, [], $headers);

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
        $data = $this->requestSender->get(self::API_URL_LANDING_PAGE, [], $headers);

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
