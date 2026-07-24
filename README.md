# Met Office Weather DataHub API Client

[![CI](https://github.com/christianjbrown/php-met-office-weather-datahub-api-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-met-office-weather-datahub-api-lib/actions/workflows/ci.yml)

A strongly-typed, **read-only** PHP client for the [Met Office Weather DataHub](https://datahub.metoffice.gov.uk/) APIs. It returns plain, typed model objects rather than raw GeoJSON / CoverageJSON arrays. The library is structured to host multiple DataHub APIs side by side; its supported APIs are **Site-Specific** (Global Spot), **Site-Specific Blended Probabilistic Forecast**, **Observation (Land)**, **Atmospheric Models** (Gridded), and **Map Images**.

## :satellite: Supported APIs

| API | Entry point | Status |
| --- | --- | --- |
| **Site-Specific** (Global Spot) | `MetOffice::siteSpecific()` | ✅ Supported |
| **Site-Specific Blended Probabilistic Forecast** | `MetOffice::siteSpecificBlended()` | ✅ Supported |
| **Observation (Land)** | `MetOffice::observationLand()` | ✅ Supported |
| **Atmospheric Models** (Gridded) | `MetOffice::atmosphericModels()` | ✅ Supported |
| **Map Images** | `MetOffice::mapImages()` | ✅ Supported |

See [Coverage & limitations](#coverage--limitations) for what this library deliberately does **not** cover.

### Site-Specific (Global Spot)

Given a latitude and longitude it fetches the hourly, three-hourly, or daily point forecast and returns typed model objects. It supports the three forecast resolutions:

- **Hourly** (`getHourlyForecastApi()`) — per-hour "instant" steps: temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation rate/amount, and probability of precipitation.
- **Three-hourly** (`getThreeHourlyForecastApi()`) — per-three-hour steps: max/min air temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation/snow amounts, and the full set of precipitation-type probabilities (rain, heavy rain, snow, heavy snow, hail, sferics).
- **Daily** (`getDailyForecastApi()`) — day/night split steps: midday & midnight wind, visibility, humidity and pressure, day-max/night-min temperature and feels-like (with upper/lower bounds), max UV, day & night weather codes, and day & night precipitation-type probabilities.

Every forecast carries the resolved location name, the model run date (as a Unix timestamp), and its list of time steps.

### Observation (Land)

Fetches recent (past 48 hours) hourly land surface observations. It exposes two clients:

- **Nearest** (`getNearestApi()`) — resolves the nearest observation locations from either a latitude/longitude pair (`getByCoordinates()`, coordinates are rounded to two decimal places for the API) or a geohash (`getByGeohash()`). Each `NearestLocationInterface` carries its `geohash`, `area`, `region`, `country`, and `olsonTimeZone`.
- **Observation** (`getObservationApi()`) — given a six-character geohash, `getByGeohash()` returns the array of hourly `ObservationInterface` values (datetime as a Unix timestamp, plus optional temperature, humidity, wind speed/gust/direction, weather code, visibility, mean sea-level pressure, and pressure tendency). Results are cached per geohash; pass `true` as the second argument to bypass the cache.

```php
use ChristianBrown\MetOffice\MetOffice;

$observationLand = (new MetOffice())->observationLand('your-observation-land-apikey');

// London: latitude 51.55, longitude -0.18.
$nearest = $observationLand->getNearestApi()->getByCoordinates(51.55, -0.18);   // NearestLocationInterface[]

$observations = $observationLand->getObservationApi()->getByGeohash('gcpvj0');   // ObservationInterface[]
```

### Atmospheric Models (Gridded)

Retrieves orders for Atmospheric Model ("Gridded") data. Unlike the other APIs — which return typed weather values — the model data itself is delivered as binary GRIB files; this client returns typed metadata for the runs, orders and files, and hands you the **raw GRIB bytes** for a file (no GRIB parsing is performed). Base URL `https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0`, same `apikey` header. It exposes two clients:

- **Runs** (`getRunsApi()`) — `getRuns()` lists every available model run (`RunInterface[]`, each with a `modelId` such as `mo-uk`, `mo-global`, `mo-mogrepsg`, and its `completeRuns` — `RunDetailInterface[]` carrying the run hour, the run date-time as a Unix timestamp, and the `runFilter`). `getRunsByModel(string $modelId)` narrows the list to a single model.
- **Orders** (`getOrdersApi()`) — `getOrders()` lists the orders configured for your organisation (`OrderInterface[]`); `getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null)` lists the latest available files for an order (`OrderFileInterface[]`); `getOrderFile(string $orderId, string $fileId)` returns the detailed metadata for one file (`OrderFileDetailsInterface`, including its `ParameterDetailInterface[]`); and `getOrderFileData(string $orderId, string $fileId)` downloads the file and returns the **raw GRIB bytes as a `string`** (302 redirects are followed and the file id is URL-encoded for you).

```php
use ChristianBrown\MetOffice\MetOffice;

$atmosphericModels = (new MetOffice())->atmosphericModels('your-atmospheric-models-apikey');

$runs = $atmosphericModels->getRunsApi()->getRuns();                              // RunInterface[]

$grib = $atmosphericModels->getOrdersApi()->getOrderFileData($orderId, $fileId);  // raw GRIB bytes (string)
```

### Map Images

Retrieves orders for Map Images data. As with Atmospheric Models, the imagery itself is delivered as binary files — here **PNG** map images — so this client returns typed metadata for the runs, orders and files, and hands you the **raw PNG bytes** for a file (no image decoding is performed). Base URL `https://data.hub.api.metoffice.gov.uk/map-images/1.0.0`, same `apikey` header. It exposes two clients:

- **Runs** (`getRunsApi()`) — `getRuns()` lists every available model run (`RunInterface[]`, each with a `modelId` such as `mo-uk-mimg`, and its `completeRuns` — `RunDetailInterface[]` carrying the run hour, the run date-time as a Unix timestamp, and the `runFilter`). Unlike Atmospheric Models, Map Images has no per-model runs endpoint.
- **Orders** (`getOrdersApi()`) — `getOrders()` lists the orders configured for your organisation (`OrderInterface[]`); `getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null)` lists the latest available files for an order (`OrderFileInterface[]`); `getOrderFile(string $orderId, string $fileId)` returns the detailed metadata for one file (`OrderFileDetailsInterface`, including its `ParameterDetailInterface[]`); and `getOrderFileData(string $orderId, string $fileId)` downloads the file and returns the **raw PNG bytes as a `string`** (302 redirects are followed and the file id is URL-encoded for you).

```php
use ChristianBrown\MetOffice\MetOffice;

$mapImages = (new MetOffice())->mapImages('your-map-images-apikey');

$runs = $mapImages->getRunsApi()->getRuns();                              // RunInterface[]

$png = $mapImages->getOrdersApi()->getOrderFileData($orderId, $fileId);   // raw PNG bytes (string)
```

### Site-Specific Blended Probabilistic Forecast

The Met Office Site-Specific Blended Probabilistic Forecast (BPF) is a newer product for consuming site-specific forecasts **probabilistically** (a range of probabilities and percentiles rather than a single "most likely" value). Unlike Global Spot, it is an [OGC Environmental Data Retrieval (EDR)](https://ogcapi.ogc.org/edr/) API and returns [CoverageJSON](https://covjson.org/) — so it has its own module rather than reusing the Global Spot models. Base URL `https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0`, same `apikey` header. It exposes three clients:

- **Capabilities** (`getCapabilitiesApi()`) — `getLandingPage()` returns the API landing metadata (`LandingPageInterface`); `getConformance()` returns the conformance-class URIs (`string[]`).
- **Collections** (`getCollectionsApi()`) — `getCollections()` lists the available collections (`CollectionInterface[]`; example ids `improver-percentiles-spot-global`, `improver-probabilities-spot-uk`, each carrying its `parameterNames`, `outputFormats`, `crs`, `links`, and `extent`); `getCollection(string $collectionId)` returns one collection's metadata.
- **Locations** (`getLocationsApi()`) — `getLocations(string $collectionId)` lists the collection's available spot locations (`LocationInterface[]`, each with an `id`, latitude/longitude, and name; a collection has thousands of them); `getCoverage(string $collectionId, string $locationId, ?string $parameterName = null, ?string $datetime = null)` fetches one location's forecast as a typed **`CoverageCollectionInterface`** (the EDR endpoint returns a CoverageJSON *CoverageCollection*). It carries the shared `domainType`, a map of `ParameterInterface` metadata (each with an `observedPropertyLabel` and a `unit`), and an array of `CoverageInterface` — **one sub-coverage per parameter**. Each `CoverageInterface` has a `DomainInterface` exposing a map of named `AxisInterface` (`getAxes()` — e.g. `t`, `x`/`y`/`z`, `locationId`, and the statistical axis: `percentiles` for percentile collections, or a per-parameter `probabilityOf…Values` threshold axis for probability collections — each axis exposes `getFloatValues()` / `getStringValues()`), plus a map of `NdArrayInterface` ranges (`dataType`, `axisNames`, `shape`, and position-aligned `values` that may contain `null` gaps). The optional `parameter-name` and `datetime` query params are only sent when supplied.

```php
use ChristianBrown\MetOffice\MetOffice;

$blended = (new MetOffice())->siteSpecificBlended('your-blended-probabilistic-apikey');

$collections = $blended->getCollectionsApi()->getCollections();                     // CollectionInterface[]
$locations   = $blended->getLocationsApi()->getLocations('improver-percentiles-spot-global');   // LocationInterface[]

$coverageCollection = $blended->getLocationsApi()->getCoverage(
    'improver-percentiles-spot-global',
    $locations[0]->getId(),
    'feels_like_temperature',   // optional parameter-name filter
    '2026-07-23T11:00:00Z',     // optional datetime filter
);   // CoverageCollectionInterface

foreach ($coverageCollection->getCoverages() as $coverage) {
    $timeAxis = $coverage->getDomain()->getAxes()['t'] ?? null;   // AxisInterface|null
    foreach ($coverage->getRanges() as $parameterId => $range) {
        // $range->getValues() is a flat float array aligned to $range->getShape()
        // (e.g. shape [15, 206] = 15 percentiles x 206 time steps); nulls mark gaps.
        $unit = $coverageCollection->getParameters()[$parameterId]?->getUnit();
        printf("%s: %d values in %s\n", $parameterId, count($range->getValues()), $unit ?? '?');
    }
}
```



## :no_entry_sign: Coverage & limitations

This library aims for full parity with the DataHub API **products**, but is deliberately scoped. What it does **not** cover:

- **Radar** — the Met Office radar composites (UK / NW-European surface rain-rate, HDF5) are **not** part of the DataHub REST API; they are distributed separately via [AWS Open Data](https://registry.opendata.aws/met-office-uk-radar-observations/) (an S3 object store, no `apikey` header). They are out of scope for this DataHub client.
- **Order creation / management** — the library is **read-only**. For Atmospheric Models and Map Images it reads existing orders (`/orders`, `/orders/{id}/latest`, files, and file data) but never creates, modifies, or deletes orders (there are no `POST`/`PUT`/`DELETE` calls). Orders are configured in the DataHub portal.
- **No binary decoding** — Atmospheric Models GRIB and Map Images PNG payloads are returned as **raw bytes**; the library does not parse GRIB or decode images. (Blended Probabilistic data is JSON/CoverageJSON and *is* returned as typed models.)
- **Global Spot returns forecast values only** — `dataSource` is fixed to `BD1` (the API's only permitted value). Per-parameter **metadata** (units, descriptions) is intentionally not surfaced — the library treats units as a presentation concern (the same rationale as shipping the `WeatherType` enum without display wording); the forecast values themselves are complete.
- **Map Images has no per-model runs endpoint** — only `getRuns()` is available (there is no `getRunsByModel()`); this mirrors the real API, where Map Images genuinely lacks `/runs/{modelId}`.



## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/php-met-office-weather-datahub-api-lib
```



## :computer: Usage

First, create a Met Office [Weather DataHub](https://datahub.metoffice.gov.uk/) account and subscribe to the **Site-Specific** API to obtain an API key. The key is sent to the API as the `apikey` HTTP header.

The `MetOffice` umbrella facade is the entry point for every DataHub API. Call `siteSpecific($apiKey)` to get the Site-Specific client, which builds the three forecast clients (and their transformer chains) for you through a dependency-injection container:

```php
use ChristianBrown\MetOffice\MetOffice;

$siteSpecific        = (new MetOffice())->siteSpecific('your-site-specific-apikey');
$hourlyForecastApi   = $siteSpecific->getHourlyForecastApi();       // HourlyForecastApiInterface
$threeHourlyForecast = $siteSpecific->getThreeHourlyForecastApi();  // ThreeHourlyForecastApiInterface
$dailyForecastApi    = $siteSpecific->getDailyForecastApi();        // DailyForecastApiInterface
```

You can also construct the Site-Specific facade directly, without going through the umbrella facade:

```php
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;

$siteSpecific      = new SiteSpecific('your-site-specific-apikey');
$hourlyForecastApi = $siteSpecific->getHourlyForecastApi();
```

If you'd rather wire the clients by hand, see [Wiring the clients](#wiring-the-clients) below.

Each client exposes a single `getForecast(float $latitude, float $longitude, bool $skipCache = false)` method returning a `ForecastInterface`. Results are cached per `"latitude,longitude"` pair; pass `true` as the third argument to bypass the cache and re-fetch.

```php
// London: latitude 51.5074, longitude -0.1278.
$forecast = $hourlyForecastApi->getForecast(51.5074, -0.1278);   // ForecastInterface

echo $forecast->getLocationName(), "\n";                         // e.g. "London"
echo date('c', $forecast->getModelRunDate() ?? 0), "\n";         // model run date (Unix -> ISO)

foreach ($forecast->getTimeSteps() as $step) {
    // Every step implements ForecastTimeStepInterface (getTime(): int, a Unix timestamp).
    // The hourly client yields HourlyForecastTimeStepInterface instances.
    if ($step instanceof \ChristianBrown\MetOffice\SiteSpecific\Model\HourlyForecastTimeStepInterface) {
        printf(
            "%s  %.1f°C  wind %.1f m/s\n",
            date('H:i', $step->getTime()),
            $step->getScreenTemperature() ?? 0.0,
            $step->getWindSpeed10m() ?? 0.0,
        );
    }
}
```

### Wind direction and weather codes

Wind direction is stored as raw degrees (`getWindDirectionFrom10m()` / `getMidday10MWindDirection()`, an `?int`). Convert a bearing to a 16-point compass value with the `WindDirection` enum:

```php
use ChristianBrown\MetOffice\Enums\WindDirection;

$direction = WindDirection::fromDegrees(200);   // WindDirection::SOUTH_SOUTH_WEST
echo $direction->value;                          // "SSW"
```

Weather codes are decoded to the `WeatherType` enum (`getSignificantWeatherCode()`, `getDaySignificantWeatherCode()`, …, an `?WeatherType`). The enum is the readable, debuggable form of the raw Met Office code — use `->value` for the numeric code and `->name` for a stable string token. Display wording (a human-readable name or emoji) is intentionally **not** provided here; it is a locale-sensitive presentation concern and belongs to the consumer:

```php
use ChristianBrown\MetOffice\Enums\WeatherType;

$type = WeatherType::SUNNY_DAY;
echo $type->value;   // 1        (raw Met Office significant weather code)
echo $type->name;    // "SUNNY_DAY"  (stable token to map to a display string / emoji)
```



## :rotating_light: Error handling

Everything this library throws implements `ChristianBrown\MetOffice\Exception\ExceptionInterface`, so a single `catch` covers it all:

```php
use ChristianBrown\MetOffice\Exception\ExceptionInterface;

try {
    $forecast = $hourlyForecastApi->getForecast(51.5074, -0.1278);
} catch (ExceptionInterface $exception) {
    // Anything this library throws lands here.
}
```

There are two concrete types:

- **`UnexpectedResponseException`** (extends `RuntimeException`) — the API returned a body the client or a transformer couldn't parse (a missing/mis-typed field, an empty `features` collection, an unparseable `time`).
- **`MissingInputException`** (extends `InvalidArgumentException`) — reserved for bad caller input.

Both live in `src/Exception/`. Request-level failures (network errors, non-2xx responses) still surface as `RequestExceptionInterface` from [`christianjbrown/php-api-client-lib`](https://github.com/christianjbrown/php-api-client-lib), which is outside this library's exception hierarchy.

Under the hood, `SiteSpecific` wires the clients and their transformer chains through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chains by hand — as shown below. The HTTP request sender comes from [`christianjbrown/php-api-client-lib`](https://github.com/christianjbrown/php-api-client-lib).

<details id="wiring-the-clients">
<summary><strong>Wiring the clients</strong></summary>

```php
use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ThreeHourlyForecastTimeStepTransformer;

$apiKey = 'your-site-specific-apikey';

// Shared JSON request sender (wires Guzzle for you).
$requestSender = (new ApiClient())->getJsonApiRequestSender();

// Hourly client (the same "instant" ForecastTransformer chain also serves three-hourly).
$hourlyForecastApi = new HourlyForecastApi(
    $requestSender,
    new ForecastTransformer(
        new ForecastTimeStepsTransformer(
            new HourlyForecastTimeStepTransformer()
        )
    ),
    $apiKey
);

// Three-hourly client.
$threeHourlyForecastApi = new ThreeHourlyForecastApi(
    $requestSender,
    new ForecastTransformer(
        new ForecastTimeStepsTransformer(
            new ThreeHourlyForecastTimeStepTransformer()
        )
    ),
    $apiKey
);

// Daily client.
$dailyForecastApi = new DailyForecastApi(
    $requestSender,
    new ForecastTransformer(
        new ForecastTimeStepsTransformer(
            new DailyForecastTimeStepTransformer()
        )
    ),
    $apiKey
);
```

</details>

## :page_facing_up: License

Released under the [MIT License](LICENSE).
