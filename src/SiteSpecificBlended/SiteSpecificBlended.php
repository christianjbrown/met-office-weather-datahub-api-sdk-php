<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CollectionsApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ConformanceTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangeTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SiteSpecificBlended implements SiteSpecificBlendedInterface
{
    private string $apiKey;
    private ContainerBuilder $container;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->container = new ContainerBuilder();
        $this->init();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCapabilitiesApi(): CapabilitiesApiInterface
    {
        /**
         * @var CapabilitiesApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_CAPABILITIES_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCollectionsApi(): CollectionsApiInterface
    {
        /**
         * @var CollectionsApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_COLLECTIONS_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLocationsApi(): LocationsApiInterface
    {
        /**
         * @var LocationsApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATIONS_API);

        return $service;
    }

    private function init(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $this->container->register(self::SERVICE_API_KEY, ApiKey::class)
            ->setArguments(
                [
                    $this->apiKey,
                ]
            );

        $this->container->register(self::SERVICE_LINK_TRANSFORMER, LinkTransformer::class);
        $this->container->register(self::SERVICE_LINKS_TRANSFORMER, LinksTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINK_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EXTENT_TRANSFORMER, ExtentTransformer::class);

        $this->container->register(self::SERVICE_LANDING_PAGE_TRANSFORMER, LandingPageTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CONFORMANCE_TRANSFORMER, ConformanceTransformer::class);

        $this->container->register(self::SERVICE_COLLECTION_TRANSFORMER, CollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EXTENT_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_COLLECTIONS_TRANSFORMER, CollectionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_COLLECTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $this->container->register(self::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PARAMETER_TRANSFORMER, ParameterTransformer::class);
        $this->container->register(self::SERVICE_PARAMETERS_TRANSFORMER, ParametersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PARAMETER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_RANGE_TRANSFORMER, RangeTransformer::class);
        $this->container->register(self::SERVICE_RANGES_TRANSFORMER, RangesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RANGE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_AXIS_TRANSFORMER, AxisTransformer::class);
        $this->container->register(self::SERVICE_AXES_TRANSFORMER, AxesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AXIS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DOMAIN_TRANSFORMER, DomainTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AXES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COVERAGE_TRANSFORMER, CoverageTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DOMAIN_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_RANGES_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_COVERAGES_TRANSFORMER, CoveragesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_COVERAGE_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_COVERAGE_COLLECTION_TRANSFORMER, CoverageCollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PARAMETERS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_COVERAGES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CAPABILITIES_API, CapabilitiesApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LANDING_PAGE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CONFORMANCE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_COLLECTIONS_API, CollectionsApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_COLLECTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_LOCATIONS_API, LocationsApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LOCATIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_COVERAGE_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
    }
}
