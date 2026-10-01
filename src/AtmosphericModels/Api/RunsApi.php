<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Coverage\Model\RunInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHostInterface;

use function is_array;
use function sprintf;

final class RunsApi implements RunsApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiKeyInterface $apiKey;
    private JsonReadApiRequestSenderInterface $requestSender;
    private RunsTransformerInterface $runsTransformer;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, RunsTransformerInterface $runsTransformer, ApiKeyInterface $apiKey, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->runsTransformer = $runsTransformer;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, RunInterface>
     */
    public function getRuns(?string $sort = null): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get($this->apiHost->rewrite(self::API_URL_RUNS), self::buildRunsQuery($sort), $headers);

        return $this->runsTransformer->transform(self::extractRuns($data));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, RunInterface>
     */
    public function getRunsByModel(string $modelId, ?string $sort = null): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get($this->apiHost->rewrite(sprintf(self::API_URL_RUNS_BY_MODEL_SPRINTF, $modelId)), self::buildRunsQuery($sort), $headers);

        return $this->runsTransformer->transform(self::extractRuns($data));
    }

    /**
     * @return array<string, string>
     */
    private static function buildRunsQuery(?string $sort): array
    {
        $query = [];
        if (null !== $sort) {
            $query[self::QUERY_KEY_SORT] = $sort;
        }

        return $query;
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractRuns(array $data): array
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
