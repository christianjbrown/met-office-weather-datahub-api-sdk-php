<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ConformanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangeTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class BlendedProbForecast implements BlendedProbForecastInterface
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
    public function getInstancesApi(): InstancesApiInterface
    {
        /**
         * @var InstancesApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_INSTANCES_API);

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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPositionApi(): PositionApiInterface
    {
        /**
         * @var PositionApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_POSITION_API);

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

        $this->container->register(self::SERVICE_EXTENT_CUSTOM_TRANSFORMER, ExtentCustomTransformer::class);
        $this->container->register(self::SERVICE_EXTENT_CUSTOMS_TRANSFORMER, ExtentCustomsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EXTENT_CUSTOM_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_EXTENT_TRANSFORMER, ExtentTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EXTENT_CUSTOMS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LANDING_PAGE_TRANSFORMER, LandingPageTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CONFORMANCE_TRANSFORMER, ConformanceTransformer::class);

        $this->container->register(self::SERVICE_PARAMETER_TRANSFORMER, ParameterTransformer::class);
        $this->container->register(self::SERVICE_PARAMETERS_TRANSFORMER, ParametersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PARAMETER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COLLECTION_TRANSFORMER, CollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EXTENT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PARAMETERS_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_COLLECTIONS_TRANSFORMER, CollectionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_COLLECTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_INSTANCE_TRANSFORMER, InstanceTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EXTENT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PARAMETERS_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_INSTANCES_TRANSFORMER, InstancesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_INSTANCE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $this->container->register(self::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
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

        $this->container->register(self::SERVICE_REFERENCE_SYSTEM_TRANSFORMER, ReferenceSystemTransformer::class);
        $this->container->register(self::SERVICE_REFERENCING_TRANSFORMER, ReferencingTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REFERENCE_SYSTEM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COVERAGE_TRANSFORMER, CoverageTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DOMAIN_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PARAMETERS_TRANSFORMER),
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
                    $this->container->getDefinition(self::SERVICE_COVERAGES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_REFERENCING_TRANSFORMER),
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
        $this->container->register(self::SERVICE_INSTANCES_API, InstancesApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_INSTANCES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_INSTANCE_TRANSFORMER),
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
        $this->container->register(self::SERVICE_POSITION_API, PositionApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_COVERAGE_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
    }
}
