# Met Office API Client

[![CI](https://github.com/christianjbrown/php-met-office-api-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-met-office-api-lib/actions/workflows/ci.yml)

A strongly-typed PHP client for the [Met Office Weather DataHub](https://datahub.metoffice.gov.uk/) **Site-Specific** (Global Spot) API. Given a latitude and longitude it fetches the hourly, three-hourly, or daily forecast for that point and returns plain, typed model objects rather than raw GeoJSON arrays.

The client is **read-only** and supports the three Site-Specific forecast resolutions:

- **Hourly** (`getHourlyForecastApi()`) — per-hour "instant" steps: temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation rate/amount, and probability of precipitation.
- **Three-hourly** (`getThreeHourlyForecastApi()`) — per-three-hour steps: max/min air temperature, feels-like, wind, visibility, humidity, pressure, UV, weather code, precipitation/snow amounts, and the full set of precipitation-type probabilities (rain, heavy rain, snow, heavy snow, hail, sferics).
- **Daily** (`getDailyForecastApi()`) — day/night split steps: midday & midnight wind, visibility, humidity and pressure, day-max/night-min temperature and feels-like (with upper/lower bounds), max UV, day & night weather codes, and day & night precipitation-type probabilities.

Every forecast carries the resolved location name, the model run date (as a Unix timestamp), and its list of time steps.



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

First, create a Met Office [Weather DataHub](https://datahub.metoffice.gov.uk/) account and subscribe to the **Site-Specific** API to obtain an API key. The key is sent to the API as the `apikey` HTTP header, and is passed to the `MetOffice` entry point.

The quickest way to get the three clients is the `MetOffice` entry point, which builds them (and their transformer chains) for you through a dependency-injection container — just pass your key:

```php
use ChristianBrown\MetOffice\MetOffice;

$metOffice           = new MetOffice('your-met-office-datahub-api-key');
$hourlyForecastApi   = $metOffice->getHourlyForecastApi();       // HourlyForecastApiInterface
$threeHourlyForecast = $metOffice->getThreeHourlyForecastApi();  // ThreeHourlyForecastApiInterface
$dailyForecastApi    = $metOffice->getDailyForecastApi();        // DailyForecastApiInterface
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
    if ($step instanceof \ChristianBrown\MetOffice\Model\HourlyForecastTimeStepInterface) {
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

Under the hood, `MetOffice` wires the clients and their transformer chains through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chains by hand — as shown below. The HTTP request sender comes from [`christianjbrown/php-api-client-lib`](https://github.com/christianjbrown/php-api-client-lib).

<details id="wiring-the-clients">
<summary><strong>Wiring the clients</strong></summary>

```php
use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\MetOffice\Api\DailyForecastApi;
use ChristianBrown\MetOffice\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\ThreeHourlyForecastTimeStepTransformer;

$apiKey = 'your-met-office-datahub-api-key';

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
