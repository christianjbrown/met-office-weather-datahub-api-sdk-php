<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Coverage\Model\RunInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function sprintf;

final class RunsApi implements RunsApiInterface
{
    private ApiKeyInterface $apiKey;
    private JsonApiRequestSenderInterface $requestSender;
    private RunsTransformerInterface $runsTransformer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, RunsTransformerInterface $runsTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->runsTransformer = $runsTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, RunInterface>
     */
    public function getRuns(): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(self::API_URL_RUNS, [], $headers);

        return $this->runsTransformer->transform($this->extractRuns($data));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, RunInterface>
     */
    public function getRunsByModel(string $modelId): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_RUNS_BY_MODEL_SPRINTF, $modelId), [], $headers);

        return $this->runsTransformer->transform($this->extractRuns($data));
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function extractRuns(array $data): array
    {
        if (!isset($data[self::KEY_RUNS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RUNS));
        }
        if (!is_array($data[self::KEY_RUNS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RUNS));
        }

        return $data[self::KEY_RUNS];
    }
}
