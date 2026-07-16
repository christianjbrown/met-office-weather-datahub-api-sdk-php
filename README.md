# Met Office API Client

[![CI](https://github.com/christianjbrown/php-met-office-api-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-met-office-api-lib/actions/workflows/ci.yml)

A strongly-typed, **read-only** PHP client for the [Met Office Weather DataHub](https://datahub.metoffice.gov.uk/) APIs. It returns plain, typed model objects rather than raw GeoJSON arrays. The library is structured to host multiple DataHub APIs side by side; its supported APIs are **Site-Specific** (Global Spot) and **Observation (Land)**.

## :satellite: Supported APIs

| API | Entry point | Status |
| --- | --- | --- |
| **Site-Specific** (Global Spot) | `MetOffice::siteSpecific()` | ✅ Supported |
| **Observation (Land)** | `MetOffice::observationLand()` | ✅ Supported |
| Atmospheric Models | — | 🔜 Planned |
| Map Images | — | 🔜 Planned |

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



## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/php-met-office-api-lib
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

Weather codes are decoded to the `WeatherType` enum (`getSignificantWeatherCode()`, `getDaySignificantWeatherCode()`, …, an `?WeatherType`). Turn one into a display string or emoji with `WeatherTypeTransformer`:

```php
use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Transformer\WeatherTypeTransformer;

$weatherTypeTransformer = new WeatherTypeTransformer();
echo $weatherTypeTransformer->transform(WeatherType::SUNNY_DAY);         // "Sunny day"
echo $weatherTypeTransformer->transformToEmoji(WeatherType::SUNNY_DAY);  // "☀️"
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
