<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPageInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ConformanceTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilitiesApi::class)]
#[UsesClass(ApiKey::class)]
final class CapabilitiesApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConformance(): void
    {
        $conformsToData = ['http://www.opengis.net/spec/ogcapi-common-1/1.0/conf/core'];
        $data = [CapabilitiesApiInterface::KEY_CONFORMS_TO => $conformsToData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                CapabilitiesApiInterface::API_URL_CONFORMANCE,
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    CapabilitiesApiInterface::HEADER_KEY_ACCEPT => CapabilitiesApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $conformance = ['http://www.opengis.net/spec/ogcapi-common-1/1.0/conf/core'];

        $landingPageTransformer = self::createMock(LandingPageTransformerInterface::class);
        $landingPageTransformer->expects(self::never())->method('transform');

        $conformanceTransformer = self::createMock(ConformanceTransformerInterface::class);
        $conformanceTransformer->expects(self::once())
            ->method('transform')
            ->with($conformsToData)
            ->willReturn($conformance);

        $api = new CapabilitiesApi($requestSender, $landingPageTransformer, $conformanceTransformer, new ApiKey('test-api-key'));

        self::assertSame($conformance, $api->getConformance());
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[CapabilitiesApiInterface::KEY_CONFORMS_TO => 'not-an-array']])]
    public function testGetConformanceThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $landingPageTransformer = self::createStub(LandingPageTransformerInterface::class);

        $conformanceTransformer = self::createMock(ConformanceTransformerInterface::class);
        $conformanceTransformer->expects(self::never())->method('transform');

        $api = new CapabilitiesApi($requestSender, $landingPageTransformer, $conformanceTransformer, new ApiKey('test-api-key'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilitiesApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilitiesApiInterface::KEY_CONFORMS_TO));

        $api->getConformance();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLandingPage(): void
    {
        $data = ['title' => 'Met Office Site Specific Blended Probabilistic Forecast'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                CapabilitiesApiInterface::API_URL_LANDING_PAGE,
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    CapabilitiesApiInterface::HEADER_KEY_ACCEPT => CapabilitiesApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $landingPage = self::createStub(LandingPageInterface::class);

        $landingPageTransformer = self::createMock(LandingPageTransformerInterface::class);
        $landingPageTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($landingPage);

        $conformanceTransformer = self::createMock(ConformanceTransformerInterface::class);
        $conformanceTransformer->expects(self::never())->method('transform');

        $api = new CapabilitiesApi($requestSender, $landingPageTransformer, $conformanceTransformer, new ApiKey('test-api-key'));

        self::assertSame($landingPage, $api->getLandingPage());
    }
}
