# Met Office Weather DataHub API SDK

[![CI](https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/actions/workflows/ci.yml) [![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)](https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/actions/workflows/ci.yml) [![Packagist](https://img.shields.io/packagist/v/christianjbrown/met-office-weather-datahub-api-sdk)](https://packagist.org/packages/christianjbrown/met-office-weather-datahub-api-sdk) [![License](https://img.shields.io/packagist/l/christianjbrown/met-office-weather-datahub-api-sdk)](https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/blob/main/LICENSE) [![PHP](https://img.shields.io/packagist/dependency-v/christianjbrown/met-office-weather-datahub-api-sdk/php)](https://packagist.org/packages/christianjbrown/met-office-weather-datahub-api-sdk)

A strongly-typed, **read-only** PHP client for the [Met Office Weather DataHub](https://datahub.metoffice.gov.uk/) APIs. It returns plain, typed model objects rather than raw GeoJSON / CoverageJSON arrays. The library is structured to host multiple DataHub APIs side by side; its supported APIs are **Site-Specific** (Global Spot), **Blended Probabilistic Forecast**, **Observation (Land)**, **Atmospheric Models** (Gridded), and **Map Images**.

## :satellite: Supported APIs

| API | Entry point | API version | Status |
| --- | --- | --- | --- |
| **Site-Specific** (Global Spot) | `MetOffice::siteSpecific()` | `v0` | ✅ Supported |
| **Blended Probabilistic Forecast** | `MetOffice::blendedProbForecast()` | `2.0.0` | ✅ Supported |
| **Observation (Land)** | `MetOffice::observationLand()` | `1` | ✅ Supported |
| **Atmospheric Models** (Gridded) | `MetOffice::atmosphericModels()` | `1.0.0` | ✅ Supported |
| **Map Images** | `MetOffice::mapImages()` | `1.0.0` | ✅ Supported |

The **API version** column is the DataHub API version each module targets, taken verbatim from the upstream
URL path — the Met Office versions each product independently and inconsistently, hence the mix of `v0`, `1`
and `1.0.0`. It is **not** related to this package's own version: the package version describes the PHP
contract (class names, method signatures, return types), which is what breaks your build, while the upstream
version is an implementation detail living only in each module's `Api\ApiInterface` URL constants. A new
upstream major does not imply a new package major, or vice versa.

See [Coverage & limitations](#coverage--limitations) for what this library deliberately does **not** cover.

### Site-Specific (Global Spot)

Given a latitude and longitude it fetches the hourly, three-hourly, or daily point forecast and returns typed model objects. It supports the three forecast resolutions:

- **Hourly** (`getHourlyForecastApi()`) — per-hour "instant" steps: temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation rate/amount, and probability of precipitation.
- **Three-hourly** (`getThreeHourlyForecastApi()`) — per-three-hour steps: max/min air temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation/snow amounts, and the full set of precipitation-type probabilities (rain, heavy rain, snow, heavy snow, hail, sferics).
- **Daily** (`getDailyForecastApi()`) — day/night split steps: midday & midnight wind, visibility, humidity and pressure, day-max/night-min temperature and feels-like (with upper/lower bounds), max UV, day & night weather codes, and day & night precipitation-type probabilities.

Every forecast carries the resolved location name (and its `licence` attribution), the model run date (as a Unix timestamp), the elevation of the resolved point (from the response geometry), and the distance from the requested point in metres. Pass `true` as the third argument to `getForecast()` to additionally request per-parameter metadata (unit label/symbol, description and type), returned as a keyed `getParameters(): array<string, ParameterMetadataInterface>` — this also switches the API's `excludeParameterMetadata` query parameter to `false`, so it is opt-in and does not change existing calls.

### Observation (Land)

Fetches recent (past 48 hours) hourly land surface observations. It exposes two clients:

- **Nearest** (`getNearestApi()`) — resolves the nearest observation locations from either a latitude/longitude pair (`getByCoordinates()`, coordinates are rounded to two decimal places for the API) or a geohash (`getByGeohash()`). Both accept an optional `?int $max` (1–5, API default 1) to return more than one nearest location. Each `NearestLocationInterface` carries its `geohash`, `area`, `region`, `country`, and `olsonTimeZone`.
- **Observation** (`getObservationApi()`) — given a six-character geohash, `getByGeohash()` returns the array of hourly `ObservationInterface` values (datetime as a Unix timestamp, plus optional temperature, humidity, wind speed/gust/direction, weather code, visibility, mean sea-level pressure, and pressure tendency). Results are cached per geohash; pass `true` as the second argument to bypass the cache.

```php
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\MetOfficeFactory;

$observationLand = (new MetOfficeFactory())->create()->observationLand('your-observation-land-apikey');

// London: latitude 51.55, longitude -0.18.
$nearest = $observationLand->getNearestApi()->getByCoordinates(new Coordinates(51.55, -0.18));   // NearestLocationInterface[]

$observations = $observationLand->getObservationApi()->getByGeohash('gcpvj0');   // ObservationInterface[]
```

### Atmospheric Models (Gridded)

Retrieves orders for Atmospheric Model ("Gridded") data. Unlike the other APIs — which return typed weather values — the model data itself is delivered as binary GRIB files; this client returns typed metadata for the runs, orders and files, and hands you the **raw GRIB bytes** for a file (no GRIB parsing is performed). Base URL `https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0`, same `apikey` header. It exposes two clients:

- **Runs** (`getRunsApi()`) — `getRuns(?string $sort = null)` lists every available model run (`RunInterface[]`, each with a `modelId` such as `mo-uk`, `mo-global`, `mo-mogrepsg`, and its `completeRuns` — `RunDetailInterface[]` carrying the run hour, the run date-time as a Unix timestamp, and the `runFilter`), optionally sorted (`RUN` or `RUNDATETIME`). `getRunsByModel(string $modelId, ?string $sort = null)` narrows the list to a single model.
- **Orders** (`getOrdersApi()`) — `getOrders(?string $detail = null)` lists the orders configured for your organisation (`OrderInterface[]`), optionally `MINIMAL` or `FULL`; `getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null)` lists the latest available files for an order (`OrderFileInterface[]`); `getOrderFile(string $orderId, string $fileId)` returns the detailed metadata for one file (`OrderFileDetailsInterface`, including its `ParameterDetailInterface[]`); and `getOrderFileData(string $orderId, string $fileId)` downloads the file and returns the **raw GRIB bytes as a `string`** (302 redirects are followed and the file id is URL-encoded for you).

```php
use ChristianBrown\MetOffice\MetOfficeFactory;

$atmosphericModels = (new MetOfficeFactory())->create()->atmosphericModels('your-atmospheric-models-apikey');

$runs = $atmosphericModels->getRunsApi()->getRuns();                              // RunInterface[]

$grib = $atmosphericModels->getOrdersApi()->getOrderFileData($orderId, $fileId);  // raw GRIB bytes (string)
```

### Map Images

Retrieves orders for Map Images data. As with Atmospheric Models, the imagery itself is delivered as binary files — here **PNG** map images — so this client returns typed metadata for the runs, orders and files, and hands you the **raw PNG bytes** for a file (no image decoding is performed). Base URL `https://data.hub.api.metoffice.gov.uk/map-images/1.0.0`, same `apikey` header. It exposes two clients:

- **Runs** (`getRunsApi()`) — `getRuns(?string $sort = null)` lists every available model run (`RunInterface[]`, each with a `modelId` such as `mo-uk-mimg`, and its `completeRuns` — `RunDetailInterface[]` carrying the run hour, the run date-time as a Unix timestamp, and the `runFilter`), optionally sorted (`RUN` or `RUNDATETIME`). Unlike Atmospheric Models, Map Images has no per-model runs endpoint.
- **Orders** (`getOrdersApi()`) — `getOrders()` lists the orders configured for your organisation (`OrderInterface[]`); `getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null)` lists the latest available files for an order (`OrderFileInterface[]`); `getOrderFile(string $orderId, string $fileId)` returns the detailed metadata for one file (`OrderFileDetailsInterface`, including its `ParameterDetailInterface[]`); and `getOrderFileData(string $orderId, string $fileId, ?bool $includeLand = null, ?bool $legend = null)` downloads the file and returns the **raw PNG bytes as a `string`** (302 redirects are followed and the file id is URL-encoded for you) — `$includeLand` merges in the optional land-cover base layer and `$legend` includes a legend in the image, both API defaults `false`.

```php
use ChristianBrown\MetOffice\MetOfficeFactory;

$mapImages = (new MetOfficeFactory())->create()->mapImages('your-map-images-apikey');

$runs = $mapImages->getRunsApi()->getRuns();                              // RunInterface[]

$png = $mapImages->getOrdersApi()->getOrderFileData($orderId, $fileId);   // raw PNG bytes (string)
```

### Blended Probabilistic Forecast

The Met Office Blended Probabilistic Forecast (BPF) is a newer product for consuming site-specific forecasts **probabilistically** (a range of probabilities and percentiles rather than a single "most likely" value). Unlike Global Spot, it is an [OGC Environmental Data Retrieval (EDR)](https://ogcapi.ogc.org/edr/) API and returns [CoverageJSON](https://covjson.org/) — so it has its own module rather than reusing the Global Spot models. Base URL `https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0`, same `apikey` header.

> **v2 only.** This module targets BPF **v2**, which is a different service on a different context path — not a version bump. v1 (`/mo-site-specific-blended-probabilistic-forecast/1.0.0`) is retired on **11 November 2026**, its collection ids were renamed, and a v1 API key will not authenticate against v2. See [Migrating from BPF v1](#migrating-from-bpf-v1).

Data is reached in four steps — **collection → instance → location → data** — and the two data queries accept an optional [`DataQuery`](#dataquery) filter so you fetch only what you need. It exposes five clients:

- **Capabilities** (`getCapabilitiesApi()`) — `getLandingPage()` returns the API landing metadata (`LandingPageInterface`); `getConformance()` returns the conformance-class URIs (`string[]`).
- **Collections** (`getCollectionsApi()`) — `getCollections()` lists the four available collections (`CollectionInterface[]`: `global-spot-percentiles`, `global-spot-probabilities`, `uk-spot-percentiles`, `uk-spot-probabilities`); `getCollection(string $collectionId)` returns one collection's metadata. Each carries its `crs`, `outputFormats`, `links`, `dataQueries`, and a keyed map of `ParameterInterface` (`getParameters()` — 73–79 parameters per collection, each with an `observedPropertyLabel`, `unit`, and the Met Office `height` / `fileSuffix` extras). Note the collection-level `extent` is empty in v2 — the real extent lives on the instance.
- **Instances** (`getInstancesApi()`) — `getInstances(string $collectionId)` lists the model runs (`InstanceInterface[]`; in practice a single instance, `blended`); `getInstance(string $collectionId, string $instanceId)` returns one. The instance carries the populated `ExtentInterface`: `getSpatialBbox()`, `getTemporalInterval()` / `getTemporalValues()` (241 hourly steps), and `getCustom()` — an `ExtentCustomInterface[]` publishing the statistical axis (for percentile collections, `id` `percentile` with values `5`…`95`).
- **Locations** (`getLocationsApi()`) — `getLocations(string $collectionId, string $instanceId)` lists the instance's spot sites (`LocationInterface[]`, thousands of them; each with an `id`, `latitude`, `longitude`, and `altitude`); `getLocation(string $collectionId, string $instanceId, string $locationId, ?DataQueryInterface $query = null)` fetches one site's forecast as a typed `CoverageCollectionInterface`.
- **Position** (`getPositionApi()`) — `getPosition(string $collectionId, string $instanceId, CoordinatesInterface $coordinates, ?DataQueryInterface $query = null)` fetches the forecast for the **nearest site** to a latitude/longitude, skipping the locations lookup entirely. It sends the required `coords` parameter as WKT `POINT(longitude latitude)`, built for you from the shared `Coordinates` value object.

Both data queries return a CoverageJSON **`CoverageCollectionInterface`**, which carries:

- `getDomainType()` — `PointSeries`.
- `getReferencing()` — a `ReferenceSystemInterface[]` describing each coordinate. The `IdentifierRS` entries expose `getIdentifiers()`, a map of axis value to human label (e.g. `50` → `50th percentile`), which is the only place those labels are published.
- `getCoverages()` — **one `CoverageInterface` per requested parameter**, each with its own `getId()` (the parameter name), its own `getParameters()` map, a `DomainInterface`, and a map of `NdArrayInterface` ranges (`dataType`, `axisNames`, `shape`, and position-aligned `values` that may contain `null` gaps).

`getDomain()->getAxes()` is a map of named `AxisInterface` — `t`, `x`/`y`/`z`, `locationId`, plus the statistical axis (`percentiles` for percentile collections, or a per-parameter `probabilityOf…Values` threshold axis for probability collections). Each axis exposes `getFloatValues()` / `getStringValues()` (the values are homogeneous, so exactly one is populated), and, for **period** parameters such as `airTemperature1p5mMaximumPt12h`, `getBounds()` — a flat array of `2n` timestamps where the lower bound of step `i` is at index `2i` and the upper at `2i + 1`.

#### DataQuery

`DataQuery` bundles the three optional filters shared by `getLocation()` and `getPosition()`. Every argument is optional; omitted filters are simply not sent.

```php
use ChristianBrown\MetOffice\BlendedProbForecast\DataQuery;

new DataQuery(
    ['airTemperature1p5m', 'airTemperature1p5mMaximumPt12h'],   // parameter-name  (comma-joined for you)
    ['50', '90'],                                               // percentiles     (comma-joined for you)
    '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',                // datetime
);
```

`datetime` is passed through verbatim and accepts the full v2 grammar: a single instant, a comma-separated list, a closed range `<start>/<end>`, an open-ended range (`<start>/..` or `../<end>`), or a repeating interval `R{n}/{start}/{duration}`.

```php
use ChristianBrown\MetOffice\BlendedProbForecast\DataQuery;
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\MetOfficeFactory;

$blended = (new MetOfficeFactory())->create()->blendedProbForecast('your-blended-prob-forecast-apikey');

$collections = $blended->getCollectionsApi()->getCollections();                        // CollectionInterface[]
$instances   = $blended->getInstancesApi()->getInstances('uk-spot-percentiles');       // InstanceInterface[]

$query = new DataQuery(['airTemperature1p5m'], ['50', '90'], '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z');

// Nearest site to London, no locations lookup needed.
$coverageCollection = $blended->getPositionApi()->getPosition(
    'uk-spot-percentiles',
    'blended',
    new Coordinates(51.55, -0.18),
    $query,
);   // CoverageCollectionInterface

foreach ($coverageCollection->getCoverages() as $coverage) {
    $timeAxis = $coverage->getDomain()->getAxes()['t'] ?? null;   // AxisInterface|null
    foreach ($coverage->getRanges() as $parameterId => $range) {
        // $range->getValues() is a flat float array aligned to $range->getShape()
        // (e.g. shape [2, 25] = 2 percentiles x 25 time steps); nulls mark gaps.
        $unit = $coverage->getParameters()[$parameterId]?->getUnit();
        printf("%s: %d values in %s\n", $parameterId, count($range->getValues()), $unit ?? '?');
    }
}
```

#### Migrating from BPF v1

| | v1 (retired 11 Nov 2026) | v2 |
| --- | --- | --- |
| Entry point | `MetOffice::siteSpecificBlended()` | `MetOffice::blendedProbForecast()` |
| Namespace | `…\SiteSpecificBlended\` | `…\BlendedProbForecast\` |
| Base path | `/mo-site-specific-blended-probabilistic-forecast/1.0.0` | `/mo-blended-prob-forecast-feature-svc/2.0.0` |
| API key | v1 subscription key | **new v2 key required** |
| Collection ids | `improver-percentiles-spot-global`, … | `global-spot-percentiles`, `global-spot-probabilities`, `uk-spot-percentiles`, `uk-spot-probabilities` |
| Locations | `getLocations($collectionId)` | `getLocations($collectionId, $instanceId)` |
| Location data | `getCoverage($collectionId, $locationId, ?$parameterName, ?$datetime)` | `getLocation($collectionId, $instanceId, $locationId, ?DataQueryInterface)` |
| Nearest point | — | `getPositionApi()->getPosition(…)` |
| Parameter names | `Collection::getParameterNames(): string[]` | `Collection::getParameters(): ParameterInterface[]` (keyed) |
| Coverage parameters | `CoverageCollection::getParameters()` | `Coverage::getParameters()` (per coverage) plus `CoverageCollection::getReferencing()` |
| Parameter ids | snake_case (`feels_like_temperature`) | camelCase (`feelsLikeTemperature1p5m`) |

Parameter ids were renamed wholesale for v2. The full mapping is reproduced as a searchable table in [docs/bpf-v1-to-v2-parameter-names.md](docs/bpf-v1-to-v2-parameter-names.md) — 157 entries, transcribed from the Met Office's [v1 → v2 parameter name changes PDF](https://datahub.metoffice.gov.uk/downloads/bpf-v2-parameter-name-changes) and verified against the live API (the PDF itself lists two spurious rows, documented there). This library treats parameter names as opaque strings, so no code change is needed beyond updating the names you pass to `DataQuery`.



## :no_entry_sign: Coverage & limitations

This library aims for full parity with the DataHub API **products**, but is deliberately scoped. What it does **not** cover:

- **Radar** — the Met Office radar composites (UK / NW-European surface rain-rate, HDF5) are **not** part of the DataHub REST API; they are distributed separately via [AWS Open Data](https://registry.opendata.aws/met-office-uk-radar-observations/) (an S3 object store, no `apikey` header). They are out of scope for this DataHub client. Confirmed against the current Atmospheric Models, Map Images, Site-Specific and Observation (Land) OpenAPI specifications, none of which reference radar.
- **Order creation / management** — the library is **read-only**. Both the Atmospheric Models (`v2.1.0`) and Map Images (`v1.1.0`) OpenAPI specifications confirm every `/orders` path is `GET`-only — there is no `POST`, `PUT`, `PATCH` or `DELETE` operation to implement. It reads existing orders (`/orders`, `/orders/{id}/latest`, files, and file data) but never creates, modifies, or deletes them. Orders are configured in the DataHub portal.
- **No binary decoding** — Atmospheric Models GRIB and Map Images PNG payloads are returned as **raw bytes**; the library does not parse GRIB or decode images. (Blended Probabilistic Forecast data is JSON/CoverageJSON/GeoJSON and *is* returned as typed models.)
- **`dataSource` is fixed to `BD1`** — the only value the Site-Specific Forecast OpenAPI specification's live gateway currently permits, so there is nothing to make configurable.
- **Map Images has no per-model runs endpoint** — only `getRuns()` is available (there is no `getRunsByModel()`); this mirrors the real API, where Map Images genuinely lacks `/runs/{modelId}`.
- **`dataSpec` is not exposed** — every Atmospheric Models order/run endpoint has an optional `dataSpec` query parameter, but its OpenAPI schema lists exactly one valid value (`1.1.0`, also the default), so omitting it already produces identical behaviour.



## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/met-office-weather-datahub-api-sdk
```



## :computer: Usage

First, create a Met Office [Weather DataHub](https://datahub.metoffice.gov.uk/) account and subscribe to the **Site-Specific** API to obtain an API key. The key is sent to the API as the `apikey` HTTP header.

The `MetOffice` umbrella facade is the entry point for every DataHub API. Call `siteSpecific($apiKey)` to get the Site-Specific client, which builds the three forecast clients (and their transformer chains) for you through a dependency-injection container:

```php
use ChristianBrown\MetOffice\MetOfficeFactory;

$siteSpecific        = (new MetOfficeFactory())->create()->siteSpecific('your-site-specific-apikey');
$hourlyForecastApi   = $siteSpecific->getHourlyForecastApi();       // HourlyForecastApiInterface
$threeHourlyForecast = $siteSpecific->getThreeHourlyForecastApi();  // ThreeHourlyForecastApiInterface
$dailyForecastApi    = $siteSpecific->getDailyForecastApi();        // DailyForecastApiInterface
```

You can also build the Site-Specific facade directly, without going through the umbrella facade. Each product has its own factory (`SiteSpecificFactory`, `ObservationLandFactory`, `BlendedProbForecastFactory`, `MapImagesFactory`, `AtmosphericModelsFactory`):

```php
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactory;

$siteSpecific      = (new SiteSpecificFactory())->create('your-site-specific-apikey', new ApiHost());
$hourlyForecastApi = $siteSpecific->getHourlyForecastApi();
```

If you'd rather wire the clients by hand, see [Wiring the clients](#wiring-the-clients) below.

Each client exposes a single `getForecast(CoordinatesInterface $coordinates, bool $skipCache = false)` method returning a `ForecastInterface`. The lat/lon pair is a single `Coordinates` value object rather than two positional floats, so it cannot be silently transposed. Results are cached per `"latitude,longitude"` pair; pass `true` as the second argument to bypass the cache and re-fetch.

```php
use ChristianBrown\MetOffice\Coordinates;

// London: latitude 51.5074, longitude -0.1278.
$forecast = $hourlyForecastApi->getForecast(new Coordinates(51.5074, -0.1278));   // ForecastInterface

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
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\Exception\ExceptionInterface;

try {
    $forecast = $hourlyForecastApi->getForecast(new Coordinates(51.5074, -0.1278));
} catch (ExceptionInterface $exception) {
    // Anything this library throws lands here.
}
```

There are two concrete types:

- **`UnexpectedResponseException`** (extends `RuntimeException`) — the API returned a body the client or a transformer couldn't parse (a missing/mis-typed field, an empty `features` collection, an unparseable `time`).
- **`MissingInputException`** (extends `InvalidArgumentException`) — reserved for bad caller input.

Both live in `src/Exception/`. Request-level failures (network errors, non-2xx responses) still surface as `RequestExceptionInterface` from [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php), which is outside this library's exception hierarchy.

Two Blended Probabilistic Forecast responses are worth calling out:

- **`204 No Content`** — returned by `getLocation()` / `getPosition()` when a `parameter-name` or `percentiles` filter matches nothing. The body is empty, so the JSON request sender raises `ChristianBrown\ApiClient\Exception\Parse\ParseJsonExceptionInterface` rather than returning an empty `CoverageCollectionInterface`. Treat it as "no data for that filter", and check your parameter names against the collection's `getParameters()` map.
- **`400 Bad Request`** — the body is `{"message": "…", "transaction": "<uuid>"}`. The Met Office service desk asks for that `transaction` id when reporting a problem, so capture it from the response before discarding the error.

Under the hood, every facade (`SiteSpecific`, `ObservationLand`, `AtmosphericModels`, `MapImages`, `BlendedProbForecast`) builds a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container from a fixed, ordered list of small **registrar** classes, run through a shared `RegistrarContainerFactory`. See [Composition root and registrars](#composition-root-and-registrars) for how that's put together, and [Wiring the clients by hand](#wiring-the-clients) if you don't want the container at all.

### Composition root and registrars

Each facade's constructor is its composition root: it builds an `ApiHost` (or takes the one you passed in), lists the registrars for that product in dependency order, and hands them to `RegistrarContainerFactory`. A registrar is anything implementing `ChristianBrown\MetOffice\Container\ServiceRegistrarInterface`, a single-method interface (`register(ContainerBuilder $container): void`). Two kinds are shared across every product:

- **`CoreRegistrar`** — the boilerplate every facade needs regardless of product: the transport-wrapping `ApiClient`, the JSON request sender built from it, and the `ApiKey` credential value object. This exists exactly once and every facade's registrar list starts with it.
- **`RawRequestSenderRegistrar`** — the raw (non-JSON) request sender used only by the two coverage-order products (Atmospheric Models, Map Images) to download binary GRIB/PNG order files.

Everything else is a small, `final` registrar scoped to one API resource group or one cohesive transformer chain within a product — for example `SiteSpecific\Container\HourlyForecastRegistrar` wires the hourly time-step transformer, the shared `ForecastApi`, and the `HourlyForecastApi` wrapper; `BlendedProbForecast\Container\CoverageTransformerRegistrar` wires the CoverageJSON transformer chain shared by `LocationsApi` and `PositionApi`. **Adding a new DataHub API to an existing product, or a new DataHub product entirely, means adding a registrar (or a new product namespace with its own registrars and facade) and listing it in the composition root — never editing an existing registrar's `register()` method.**

### Injectable API host

Every product's base URL is a `public const string API_URL...` on its `Api\ApiInterface`, defaulting to the real DataHub host (`ChristianBrown\MetOffice\ApiInterface::API_HOST`). Each product factory's `create()` takes the `ChristianBrown\MetOffice\Host\ApiHostInterface` to use, and `MetOfficeFactory::create()` uses production. Pass your own `ApiHost` to point a facade at a different host — a sandbox, a local stub server, a test double — without touching any of the URL constants:

```php
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\MetOfficeFactory;

$siteSpecific = (new MetOfficeFactory())->createWithHost(new ApiHost('https://sandbox.example'))->siteSpecific('your-site-specific-apikey');
```

`ApiHost::rewrite(string $url): string` replaces the production host prefix on a URL with the configured one and leaves the path and query untouched, so it works uniformly across every product's URL constants (all of which share the same `data.hub.api.metoffice.gov.uk` prefix). The Met Office DataHub itself does not publish a separate sandbox host at the time of writing — this exists for local/CI stubs and for whenever one is introduced.

<details id="wiring-the-clients">
<summary><strong>Wiring the clients by hand</strong></summary>

If you don't want the container, you can build the same chain yourself. The HTTP request sender comes from [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php).

```php
use ChristianBrown\ApiClient\ApiClientFactory;
use ChristianBrown\ApiClient\ClientOptions;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ParameterMetadataTransformer;

$apiKey = new ApiKey('your-site-specific-apikey');

// Shared JSON request sender (wires Guzzle for you).
$requestSender = (new ApiClientFactory(new ClientOptions()))->create()->getJsonApiRequestSender();

// The resolution-agnostic forecast client, given the hourly transformer chain.
$forecastApi = new ForecastApi(
    $requestSender,
    new ForecastTransformer(
        new ForecastTimeStepsTransformer(
            new HourlyForecastTimeStepTransformer()
        ),
        new ParameterMetadataTransformer()
    ),
    $apiKey
);

// The thin hourly wrapper: supplies the hourly URL and lets you override the host.
$hourlyForecastApi = new HourlyForecastApi($forecastApi, new ApiHost());
```

The three-hourly and daily clients follow the same shape with their own time-step transformer and wrapper class. The daily time-step transformer is assembled by `DailyForecastTimeStepTransformerFactory`, so use `(new DailyForecastTimeStepTransformerFactory())->create()` in place of `new HourlyForecastTimeStepTransformer()`.

</details>

## :arrow_up: Upgrading to 2.0

Facades no longer build their own dependencies. Their constructors take the API clients they expose, and the default wiring lives in factories.

```php
// Before
$siteSpecific = new SiteSpecific('your-site-specific-apikey');
$siteSpecific = new SiteSpecific('your-site-specific-apikey', new ApiHost('https://sandbox.example'));
$metOffice    = new MetOffice();

// After
$siteSpecific = (new SiteSpecificFactory())->create('your-site-specific-apikey', new ApiHost());
$siteSpecific = (new SiteSpecificFactory())->create('your-site-specific-apikey', new ApiHost('https://sandbox.example'));
$metOffice    = (new MetOfficeFactory())->create();
```

The same applies to `ObservationLand`, `BlendedProbForecast`, `MapImages` and `AtmosphericModels` (each has a `<Name>Factory`). `MetOffice` itself now takes an `ApiHostInterface` and the five product factories. The package now requires `christianjbrown/api-client` `^3.0`. The API clients type against the read-only `JsonReadApiRequestSenderInterface` and `ReadApiRequestSenderInterface`, so a custom sender only needs a `get()` method. If you build an `ApiClient` yourself, `new ApiClient()` is gone: use `(new ApiClientFactory(new ClientOptions()))->create()`. `ForecastTransformer` requires its `ParameterMetadataTransformerInterface`, and `DailyForecastTimeStepTransformer` takes its field appliers, so build it with `DailyForecastTimeStepTransformerFactory`.

## :memo: Changelog

Notable changes in each release are listed in [CHANGELOG.md](CHANGELOG.md).



## :page_facing_up: License

Released under the [MIT License](LICENSE).
