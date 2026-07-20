<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApi;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApiInterface;
use ChristianBrown\MetOffice\Coverage\Model\RunInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RunsApi::class)]
#[UsesClass(ApiKey::class)]
final class RunsApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetRuns(): void
    {
        $runsData = [['test-run']];
        $data = [RunsApiInterface::KEY_RUNS => $runsData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                RunsApiInterface::API_URL_RUNS,
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    RunsApiInterface::HEADER_KEY_ACCEPT => RunsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $run = self::createStub(RunInterface::class);
        $runs = [$run];

        $transformer = self::createMock(RunsTransformerInterface::class);
        $transformer->method('transform')
            ->with($runsData)
            ->willReturn($runs);

        $api = new RunsApi($requestSender, $transformer, new ApiKey('test-api-key'));

        self::assertSame($runs, $api->getRuns());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetRunsByModel(): void
    {
        $runsData = [['test-run']];
        $data = [RunsApiInterface::KEY_RUNS => $runsData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                sprintf(RunsApiInterface::API_URL_RUNS_BY_MODEL_SPRINTF, 'mo-uk'),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    RunsApiInterface::HEADER_KEY_ACCEPT => RunsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $run = self::createStub(RunInterface::class);
        $runs = [$run];

        $transformer = self::createMock(RunsTransformerInterface::class);
        $transformer->method('transform')
            ->with($runsData)
            ->willReturn($runs);

        $api = new RunsApi($requestSender, $transformer, new ApiKey('test-api-key'));

        self::assertSame($runs, $api->getRunsByModel('mo-uk'));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[RunsApiInterface::KEY_RUNS => 'not-an-array']])]
    public function testGetRunsThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $transformer = self::createMock(RunsTransformerInterface::class);
        $transformer->expects(self::never())->method('transform');

        $api = new RunsApi($requestSender, $transformer, new ApiKey('test-api-key'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunsApiInterface::UNEXPECTED_RESPONSE_SPRINTF, RunsApiInterface::KEY_RUNS));

        $api->getRuns();
    }
}
