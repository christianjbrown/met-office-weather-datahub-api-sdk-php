# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
small, uniform, and highly opinionated, so new code should be indistinguishable from what's here.

## What this is

A thin, strongly-typed, read-only PHP 8.5+ client for the Met Office **Weather DataHub** APIs. It is
structured to host multiple DataHub APIs side by side; its supported APIs are **Site-Specific**
(Global Spot), **Observation (Land)**, **Atmospheric Models** (Gridded), and **Map Images**. It builds on the generic `christianjbrown/php-api-client-lib`
(which wraps Guzzle and normalises transport exceptions) and wires each API's clients + transformer
chains through a Symfony `ContainerBuilder`.

The top-level entry point is the umbrella `MetOffice` facade (`src/MetOffice.php`): constructed with
**no arguments**, it is a simple factory whose `siteSpecific(string $apiKey): SiteSpecific\SiteSpecificInterface`
`observationLand(string $apiKey): ObservationLand\ObservationLandInterface`,
`atmosphericModels(string $apiKey): AtmosphericModels\AtmosphericModelsInterface`, and
`mapImages(string $apiKey): MapImages\MapImagesInterface` methods return the
per-API clients. Each API's own facade (e.g. `SiteSpecific\SiteSpecific`, `ObservationLand\ObservationLand`,
`AtmosphericModels\AtmosphericModels`, `MapImages\MapImages`, constructed with a `string $apiKey`) owns the DI container for
that API. New DataHub APIs are added as new `siteSpecific()`-style factory methods returning new
per-API facades.

Site-Specific API essentials: given a latitude/longitude it fetches the hourly, three-hourly, or daily
point forecast and returns typed model objects instead of raw GeoJSON arrays.

- **Endpoints:** `GET https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/{hourly,three-hourly,daily}`.
- **Auth:** the API key is sent as the HTTP header `apikey: <key>` (header name literally `apikey`).
  This header key and the DataHub host live on the **shared** `ChristianBrown\MetOffice\ApiInterface`
  (`src/ApiInterface.php`), which every API's `Api\ApiInterface` extends.
- **Query params** (all strings): `latitude`, `longitude`, `dataSource=BD1`,
  `excludeParameterMetadata=true`, `includeLocationName=true`.
- **Response:** GeoJSON — `features[0].properties` holds `location.name`, `modelRunDate` (ISO-8601),
  and `timeSeries` (an array of per-step objects). Each step has a `time` (ISO-8601) plus its weather
  fields. The three resolutions have **three distinct step schemas** (see `src/SiteSpecific/Model/`).

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first. The style tooling comes from the
`christianjbrown/php-code-quality-scripts` dev dependency (php-cs-fixer + PHP_CodeSniffer,
**Symfony2 coding standard**), pulled from GitHub like the other sibling dependencies.

| Task | Command |
| --- | --- |
| Run tests + coverage (opens HTML report) | `composer test` |
| Run tests, no coverage | `php -d memory_limit=-1 ./bin/phpunit --no-coverage` |
| Run one test | `php -d memory_limit=-1 ./bin/phpunit --filter HourlyForecastApiTest` |
| Static analysis (PHPStan level max) | `composer stan` |
| Check code style | `composer check-style` |
| Auto-fix code style | `composer fix-style` |
| Check / fix style on git diff only | `composer check-style-diff` / `composer fix-style-diff` |

Always run `composer fix-style` first (php-cs-fixer auto-fixes what it can), then `composer
check-style` to surface remaining violations that must be fixed by hand, then `composer stan`, then
`composer test` before finishing. CI (`.github/workflows/ci.yml`) runs the same three gates —
style → PHPStan → PHPUnit-with-coverage — on push/PR to `main`.

## Architecture

Everything lives under the `ChristianBrown\MetOffice\` namespace (`src/`), mirrored 1:1 under
`ChristianBrown\MetOffice\Tests\` (`tests/`). The layout separates **shared** code (top level) from
**per-API** code (one sub-namespace per DataHub API, starting with `SiteSpecific\`).

### Shared (top level, `ChristianBrown\MetOffice\`)

- **`MetOffice`** (`src/MetOffice.php`) — the umbrella facade. **No constructor arguments.** A plain
  factory: `siteSpecific(string $apiKey)` returns `new SiteSpecific\SiteSpecific($apiKey)`. No DI
  container at this level. Each future API gets its own factory method here.
- **`ApiInterface`** (`src/ApiInterface.php`) — the shared base interface holding only the cross-API
  constants `HEADER_KEY_API_KEY = 'apikey'` and `API_HOST`. Every API's `Api\ApiInterface` extends it.
- **`Transformer\WeatherTypeTransformer`** (+ interface) — turns a `WeatherType` into a display name or
  emoji. Shared because weather codes are a Met Office-wide concept.
- **`Enums/`** — `WeatherType` (int-backed 0–30 code table, plus `-1` for trace/NA) and
  `WindDirection` (string-backed 16-point compass with `WindDirection::fromDegrees(int): self`). Both
  are Met Office-wide concepts, so they live at the top level.
- **`Exception/`** — a flat hierarchy rooted at `ExceptionInterface extends Throwable`:
  `UnexpectedResponseException extends RuntimeException` (bad/unparseable response) and
  `MissingInputException extends InvalidArgumentException`. A single `catch (ExceptionInterface)`
  covers everything this library throws. Shared across all APIs.

### Site-Specific (`ChristianBrown\MetOffice\SiteSpecific\`)

- **`SiteSpecific\SiteSpecific`** (`src/SiteSpecific/SiteSpecific.php`) — the Site-Specific facade.
  Constructed with a `string $apiKey`, it builds a Symfony `ContainerBuilder` and registers the
  `ApiClient`, the JSON request sender, the three step transformers, three `ForecastTimeStepsTransformer`
  + `ForecastTransformer` chains, and the three API clients (ids are `SERVICE_*` constants on
  `SiteSpecificInterface`, **`met_office.site_specific.` prefix**). Exposes `getHourlyForecastApi()`,
  `getThreeHourlyForecastApi()`, `getDailyForecastApi()`.
- **`SiteSpecific\Api/`** — one client per resolution (`HourlyForecastApi`, `ThreeHourlyForecastApi`,
  `DailyForecastApi`), each constructed with `(JsonApiRequestSenderInterface, ForecastTransformerInterface,
  string $apiKey)`. `getForecast(float $latitude, float $longitude, bool $skipCache = false)` builds
  the query + `apikey` header, calls the sender, guards the `features`/`properties` shape, delegates
  `features[0].properties` to the injected `ForecastTransformer`, and caches by `"latitude,longitude"`.
  `SiteSpecific\Api\ApiInterface` **extends the shared `ChristianBrown\MetOffice\ApiInterface`** and adds
  the Site-Specific constants (query keys, `KEY_FEATURES`, `KEY_PROPERTIES`, `CACHE_KEY_SPRINTF`,
  `UNEXPECTED_RESPONSE_SPRINTF`); each endpoint interface adds its own `API_URL`.
- **`SiteSpecific\Model/`** — plain mutable DTOs. `Forecast` holds `locationName`, `modelRunDate` (Unix),
  and an array of `ForecastTimeStepInterface`. `ForecastTimeStepInterface` is the marker (`getTime(): int`)
  implemented by the three step models — `HourlyForecastTimeStep`, `ThreeHourlyForecastTimeStep`,
  `DailyForecastTimeStep` — which have **distinct field sets** (the hourly "instant" schema, the
  three-hourly schema, and the daily day/night schema). Weather codes are stored as `?WeatherType` (the
  shared enum), wind direction as raw `?int` degrees.
- **`SiteSpecific\Transformer/`** — `ForecastTransformer` builds a `Forecast`, applies optional
  `location.name` and `modelRunDate`, and delegates `timeSeries` to `ForecastTimeStepsTransformer` (a
  collection wrapping one `ForecastTimeStepTransformerInterface`). The three step transformers each
  implement that interface and narrow their return type to their concrete step interface. These
  reference the shared `Enums\WeatherType` and the shared `Transformer\WeatherTypeTransformer`.

### Observation (Land) (`ChristianBrown\MetOffice\ObservationLand\`)

Recent (past 48h) hourly land surface observations. Base URL `https://data.hub.api.metoffice.gov.uk/observation-land/1`,
same `apikey` header.

- **`ObservationLand\ObservationLand`** (`src/ObservationLand/ObservationLand.php`) — the facade.
  Constructed with a `string $apiKey`, it builds a Symfony `ContainerBuilder` and registers the
  `ApiClient`, the JSON request sender, the `NearestLocationTransformer` + `NearestLocationsTransformer`
  and `ObservationTransformer` + `ObservationsTransformer` chains, and the two API clients (ids are
  `SERVICE_*` constants on `ObservationLandInterface`, **`met_office.observation_land.` prefix**).
  Exposes `getNearestApi()` and `getObservationApi()`.
- **`ObservationLand\Api/`** — `NearestApi` (`GET /nearest`, query is either `geohash` **or** `lat`+`lon`,
  each formatted to ≤2 decimal places) with `getByCoordinates(float $latitude, float $longitude)` and
  `getByGeohash(string $geohash)` returning `NearestLocationInterface[]`; and `ObservationApi`
  (`GET /{geohash}`, geohash is a path segment) with `getByGeohash(string $geohash, bool $skipCache = false)`
  returning `ObservationInterface[]`, cached per geohash. Both build the `apikey` header, call the sender,
  and delegate the response array to their collection transformer. `Api\ApiInterface` extends the shared
  top-level `ApiInterface` and adds `API_URL_NEAREST`, `API_URL_OBSERVATION_SPRINTF`, and the `QUERY_KEY_*`
  constants.
- **`ObservationLand\Model/`** — `NearestLocation` (`geohash` required ctor arg; `area`/`region`/`country`/
  `olsonTimeZone` optional) and `Observation` (`datetime` Unix ctor arg; optional `temperature`,
  `humidity`, `windSpeed`, `windGust`, `windDirection` as `?WindDirection`, `weatherCode` as `?WeatherType`,
  `visibility`, `mslp`, `pressureTendency` raw string).
- **`ObservationLand\Transformer/`** — object transformers `NearestLocationTransformer` and
  `ObservationTransformer` (both guard their required field, then apply every optional field via `applyX`
  helpers with the same int/float and `WeatherType`/`WindDirection` `tryFrom` idioms as Site-Specific),
  wrapped by the collection transformers `NearestLocationsTransformer` and `ObservationsTransformer`
  (indexed `for` over `array_values`). All observations in the array are sparse (often only `datetime`),
  so every non-`datetime` field is optional and skipped when absent or wrong-typed.

### Coverage — shared order/run schema (`ChristianBrown\MetOffice\Coverage\`)

Atmospheric Models and Map Images are both DataHub "coverage order" APIs with an **identical**
run/order/file schema, so their `Model/` and `Transformer/` layers (previously duplicated 1:1 in each
module) live once under `ChristianBrown\MetOffice\Coverage\`:

- **`Coverage\Model/`** — `Run`/`RunDetail`, `Order`, `OrderFile`, `OrderFileDetails`,
  `ParameterDetail`, `Region`/`AxisExtent` (a region's `extent.x`/`extent.y` are each an `AxisExtent`).
  `runDateTime` values are Unix timestamps; `ParameterDetail` exposes `timeCoordinates` (from `extent.t`)
  and `verticalCoordinates` (from `extent.z`, `float[]`).
- **`Coverage\Transformer/`** — one object + one collection transformer per list
  (`RunsTransformer`/`RunTransformer`, `RunDetailsTransformer`/`RunDetailTransformer`,
  `OrdersTransformer`/`OrderTransformer`, `OrderFilesTransformer`/`OrderFileTransformer`,
  `OrderFileDetailsTransformer`, `ParameterDetailsTransformer`/`ParameterDetailTransformer`,
  `RegionsTransformer`/`RegionTransformer`, `AxisExtentTransformer`), following the same guard/`applyX`
  idioms as the other APIs. String-array fields are filtered with `array_values(array_filter(..., is_string))`
  and `extent.z` numbers pass through the sequential-`if` `toFloat()` helper (int-or-float → `float`).

Only each module's `Api/` layer stays per-module — that is where the two genuinely differ (base URL,
`Accept` header, and Map Images lacking `/runs/{modelId}`). Their tests live once under `tests/Coverage/`.

### Atmospheric Models (`ChristianBrown\MetOffice\AtmosphericModels\`)

Orders for Atmospheric Model ("Gridded") data. The model data itself is delivered as binary **GRIB**
files; this library returns typed metadata for the runs/orders/files and returns the **raw GRIB bytes
as a `string`** for a download — **no GRIB parsing is performed**. Base URL
`https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0`, same `apikey` header.

- **`AtmosphericModels\AtmosphericModels`** — the facade. Constructed with a `string $apiKey`, it builds
  a Symfony `ContainerBuilder` and registers the `ApiClient`, **both** the JSON request sender (JSON
  endpoints) **and** the raw `ApiRequestSenderInterface` (binary download) — via
  `ApiClient::getJsonApiRequestSender()` / `getApiRequestSender()` — the full transformer chains, and the
  two API clients (ids are `SERVICE_*` constants on `AtmosphericModelsInterface`, **`met_office.atmospheric_models.`
  prefix**). Exposes `getRunsApi()` and `getOrdersApi()`.
- **`AtmosphericModels\Api/`** — `RunsApi` (`GET /runs`, `GET /runs/{modelId}`) with `getRuns()` and
  `getRunsByModel(string $modelId)` returning `RunInterface[]`; and `OrdersApi` with `getOrders()`
  (`GET /orders` → `OrderInterface[]`), `getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null)`
  (`GET /orders/{orderId}/latest`, query built only for supplied params, unwraps `orderDetails.files` →
  `OrderFileInterface[]`), `getOrderFile(string $orderId, string $fileId)` (`GET /orders/{orderId}/latest/{fileId}`,
  unwraps `fileDetails` → `OrderFileDetailsInterface`), and `getOrderFileData(string $orderId, string $fileId): string`
  which uses the **raw `ApiRequestSenderInterface`** with an `Accept: application/x-grib` header,
  URL-encodes the file id, and returns the raw GRIB body string. Both build the `apikey` header; the
  JSON wrapper-shape guards live in the API classes and the per-item parsing is delegated to the
  transformers. `Api\ApiInterface` extends the shared top-level `ApiInterface` and adds the `API_URL_*`,
  `QUERY_KEY_*`, `HEADER_KEY_ACCEPT`/`HEADER_VALUE_ACCEPT_GRIB`, and JSON wrapper `KEY_*` constants.
- **Model + Transformer** — the run/order/file schema is shared with Map Images and lives under
  `ChristianBrown\MetOffice\Coverage\` (see the Coverage section above). Atmospheric Models adds no
  module-specific models or transformers; its `Api/` clients depend on `Coverage\Transformer\*` and
  return `Coverage\Model\*` types.

### Map Images (`ChristianBrown\MetOffice\MapImages\`)

Orders for Map Images data. Structurally almost identical to `AtmosphericModels\` — the schemas
(`ApiOrderInfo`, `ApiOrderFile`, `ApiRunListForModel`/`ApiRunDetails`, `ApiParameterDetails`,
`ApiRegionDetails`/`ApiOrderAxes`/`ApiAxisExtent`) are the same, so the `Model/` and `Transformer/`
layers are shared with Atmospheric Models via `ChristianBrown\MetOffice\Coverage\` (see the Coverage
section) rather than duplicated. The map images themselves are delivered as binary **PNG** files; this library
returns typed metadata for the runs/orders/files and returns the **raw PNG bytes as a `string`** for a
download — **no image decoding is performed**. Base URL
`https://data.hub.api.metoffice.gov.uk/map-images/1.0.0`, same `apikey` header.

- **`MapImages\MapImages`** — the facade. Same wiring as `AtmosphericModels\AtmosphericModels`
  (registers `ApiClient`, **both** the JSON request sender and the raw `ApiRequestSenderInterface`, the
  full transformer chains, and the two API clients; `SERVICE_*` ids on `MapImagesInterface`,
  **`met_office.map_images.` prefix**). Exposes `getRunsApi()` and `getOrdersApi()`.
- **`MapImages\Api/`** — **two differences from Atmospheric Models.** (1) Map Images has **no
  `/runs/{modelId}` endpoint**, so `RunsApi` exposes only `getRuns()` (there is no `getRunsByModel()`
  and no `API_URL_RUNS_BY_MODEL_SPRINTF`). (2) The binary `getOrderFileData()` sends
  `Accept: image/png` (`HEADER_VALUE_ACCEPT_PNG = 'image/png'`) rather than GRIB, and returns the raw
  PNG body string (302 redirects followed, file id URL-encoded). `OrdersApi` is otherwise identical
  (`getOrders()`, `getOrderFiles()`, `getOrderFile()`). **Accept header is mandatory** — the gateway
  returns `406` without it, so every JSON endpoint sends `Accept: application/json` and the raw
  download sends `Accept: image/png`. `Api\ApiInterface` extends the shared top-level `ApiInterface`.
- **Model + Transformer** — shared with Atmospheric Models under `ChristianBrown\MetOffice\Coverage\`
  (see the Coverage section); Map Images adds none of its own. Its `Api/` clients depend on
  `Coverage\Transformer\*` and return `Coverage\Model\*` types. Live-verified there is a single model,
  `mo-uk-mimg`.

### Adding a new DataHub API

Each new API gets its own `ChristianBrown\MetOffice\<ApiName>\` sub-namespace containing its `Api/`,
`Model/`, `Transformer/` (and any API-specific enums/exceptions), plus a `<ApiName>\<ApiName>` facade
that owns its DI container (service-id prefix `met_office.<api_name>.`) and an `Api\ApiInterface` that
extends the shared top-level `ApiInterface`. Wire it into the umbrella `MetOffice` facade with a new
factory method. Anything genuinely shared across APIs stays at the top level.

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace.
  There are **no abstract base classes** — the three near-identical API clients and step models each
  stand alone.
- **Constants live on the interface, not the class**: container service ids
  (`SiteSpecificInterface::SERVICE_*`), URLs (`API_URL`), request keys (`HEADER_KEY_*`, `QUERY_KEY_*`,
  `QUERY_VALUE_*`), JSON keys (`KEY_*`), and all message templates (`*_SPRINTF`). Message text never
  appears as a literal in a class body.
- **No constructor property promotion** — declare typed `private` properties and assign them in the
  constructor body. Class members (properties then methods) are ordered **alphabetically**.
- Import functions with `use function sprintf;` etc. (after class imports, blank line between), and
  call them unqualified.
- **Models** are mutable DTOs: required fields (`time`) are constructor args; every other field
  defaults to `null`. Getters are `getX()`; fluent setters are `setX($value)` (parameter literally
  `$value`) returning `$this` typed as the interface. No `readonly`.
- **Transformers** expose one `transform(array $data)`. Object transformers return a model interface;
  collection (plural) transformers return `array`. Required fields are guarded by a presence check
  then a type check, each throwing `UnexpectedResponseException(sprintf(self::..._SPRINTF, self::KEY_...))`.
  Use `empty()` for string/array presence but **`isset()` for numeric fields** (so a legit `0`/`0.0`
  survives). Optional fields are silently skipped when absent or wrong-typed, applied via private
  `applyX(Model $m, array $data): void` helpers.
- **Numeric int/float handling:** the API serialises whole-number floats as JSON ints (e.g.
  `screenTemperature: 24`). Float fields are normalised through the private `toFloat(mixed): ?float`
  helper (accept `int` or `float`, cast to `float`, else `null`) — **not** a strict `is_float`. Int
  fields use `is_int` only. Weather-code ints map via `WeatherType::tryFrom()` (skip when `null`).
- **The facade getters must stay PHPStan-safe**: `$this->container->get()` returns `mixed`, so assign
  it to a local `$service` annotated with a `/** @var XInterface $service */` docblock and return that
  — never `return $this->container->get(...)` directly.
- The HTTP layer takes `ChristianBrown\ApiClient\JsonApiRequestSenderInterface` directly and calls
  `->get($url, $queryStrings, $headers)`. There is no custom request-sender wrapper.

## Testing

The `phpunit.xml` config is strict (`requireCoverageMetadata`, `beStrictAboutCoverageMetadata`,
`failOnRisky`, `failOnWarning`, `restrictNotices`/`restrictWarnings`, path coverage). `<source>` sets
`ignoreIndirectDeprecations="true"` so Symfony DI's internal deprecations don't fail the suite.

- **Keep line, branch, method, class, AND path coverage at 100%.** Every guard and every optional-field
  state (absent / wrong-type / valid, plus the whole-number-float and zero cases) must be exercised.
  Run `composer test` and check the report (text summary to stdout + HTML at
  `.phpunit.cache/code-coverage-html/index.html`) before finishing.
- **Path coverage and compound conditions / loops.** xdebug counts a distinct path per branch
  combination, and a compound `&&` (or an explicit `foreach` with an internal `if`) generates
  phantom, unreachable paths that silently cap a method below 100%. Two idioms keep us at 100%: the
  collection transformer (`ForecastTimeStepsTransformer`) iterates with an indexed
  `for ($i = 0, $count = count($values); ...)` over `array_values($data)`; and the int-or-float guard
  uses the sequential-`if` `toFloat()` helper instead of `if (!is_int($x) && !is_float($x))`. Follow
  those idioms; avoid `foreach` and compound conditions in `src/`.
- **Every test class needs a `#[CoversClass(...)]` attribute** (the facade test additionally uses
  `#[UsesClass]` for its wired classes). Use PHPUnit 12 **attributes, not annotations**:
  `#[CoversClass]`, `#[DataProvider]`, `#[TestWith]`.
- Tests mirror `src/` 1:1 under `tests/<Layer>/`, one `final class XTest extends TestCase` per class.
- **Double every collaborator, and pick the right kind of double:** `self::createStub(...)` for a
  pure return-value double (never call `->with()` on a stub), and `self::createMock(...)` with
  `->expects(...)`/`->with(...)` for a verified collaborator. Both factories are static
  (`self::createStub(...)`), matching the `self::assertSame(...)` assertion style.
- Assert statically (`self::assertSame`) and reference the **same interface constants** production
  code uses — for data and expected exception messages — so no strings are hardcoded.

## Adding a feature

1. Add the class + its matching `...Interface` in the right layer, with any constants (service ids,
   URLs, keys, message templates) on the interface.
2. If it's a new service, register it in the owning API facade's `init()` (e.g. `SiteSpecific::init()`)
   using a new `SERVICE_*` constant.
3. Add a matching `#[CoversClass]` test under `tests/<Layer>/`, doubling all collaborators and
   exercising every guard and optional-field state (absent / wrong-type / valid / zero / whole-number
   float).
4. Run `composer fix-style`, then `composer check-style`, then `composer stan`, then `composer test`
   and **confirm the coverage report is 100%** on lines, paths, methods, and branches.
