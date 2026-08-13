<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function rawurlencode;
use function sprintf;

final class InstancesApi implements InstancesApiInterface
{
    private ApiKeyInterface $apiKey;
    private InstancesTransformerInterface $instancesTransformer;
    private InstanceTransformerInterface $instanceTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, InstancesTransformerInterface $instancesTransformer, InstanceTransformerInterface $instanceTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->instancesTransformer = $instancesTransformer;
        $this->instanceTransformer = $instanceTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getInstance(string $collectionId, string $instanceId): InstanceInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_INSTANCE_SPRINTF, $collectionId, rawurlencode($instanceId)), [], $headers);

        return $this->instanceTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, InstanceInterface>
     */
    public function getInstances(string $collectionId): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_INSTANCES_SPRINTF, $collectionId), [], $headers);

        return $this->instancesTransformer->transform(self::extractInstances($data));
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractInstances(array $data): array
    {
        if (!isset($data[self::KEY_INSTANCES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_INSTANCES));
        }
        if (!is_array($data[self::KEY_INSTANCES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_INSTANCES));
        }

        return $data[self::KEY_INSTANCES];
    }
}
