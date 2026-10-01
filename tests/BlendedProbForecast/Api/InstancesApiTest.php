<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(InstancesApi::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
final class InstancesApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstance(): void
    {
        $data = ['id' => 'blended'];

        $requestSender = self::createMock(JsonReadApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(InstancesApiInterface::API_URL_INSTANCE_SPRINTF, 'uk-spot-percentiles', rawurlencode('blended')),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    InstancesApiInterface::HEADER_KEY_ACCEPT => InstancesApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $instance = self::createStub(InstanceInterface::class);

        $instancesTransformer = self::createMock(InstancesTransformerInterface::class);
        $instancesTransformer->expects(self::never())->method('transform');

        $instanceTransformer = self::createMock(InstanceTransformerInterface::class);
        $instanceTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($instance);

        $api = new InstancesApi($requestSender, $instancesTransformer, $instanceTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($instance, $api->getInstance('uk-spot-percentiles', 'blended'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstances(): void
    {
        $instancesData = [['id' => 'blended']];
        $data = [InstancesApiInterface::KEY_INSTANCES => $instancesData];

        $requestSender = self::createMock(JsonReadApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(InstancesApiInterface::API_URL_INSTANCES_SPRINTF, 'uk-spot-percentiles'),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    InstancesApiInterface::HEADER_KEY_ACCEPT => InstancesApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $instances = [self::createStub(InstanceInterface::class)];

        $instancesTransformer = self::createMock(InstancesTransformerInterface::class);
        $instancesTransformer->expects(self::once())
            ->method('transform')
            ->with($instancesData)
            ->willReturn($instances);

        $instanceTransformer = self::createMock(InstanceTransformerInterface::class);
        $instanceTransformer->expects(self::never())->method('transform');

        $api = new InstancesApi($requestSender, $instancesTransformer, $instanceTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($instances, $api->getInstances('uk-spot-percentiles'));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[InstancesApiInterface::KEY_INSTANCES => 'not-an-array']])]
    public function testGetInstancesThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonReadApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $instancesTransformer = self::createMock(InstancesTransformerInterface::class);
        $instancesTransformer->expects(self::never())->method('transform');

        $instanceTransformer = self::createStub(InstanceTransformerInterface::class);

        $api = new InstancesApi($requestSender, $instancesTransformer, $instanceTransformer, new ApiKey('test-api-key'), new ApiHost());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstancesApiInterface::UNEXPECTED_RESPONSE_SPRINTF, InstancesApiInterface::KEY_INSTANCES));

        $api->getInstances('uk-spot-percentiles');
    }
}
