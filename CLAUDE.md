# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
small, uniform, and highly opinionated, so new code should be indistinguishable from what's here.

## What this is

A thin, strongly-typed, read-only PHP 8.5+ client for the Met Office **Weather DataHub Site-Specific**
(Global Spot) API. Given a latitude/longitude it fetches the hourly, three-hourly, or daily point
forecast and returns typed model objects instead of raw GeoJSON arrays. It builds on the generic
`christianjbrown/php-api-client-lib` (which wraps Guzzle and normalises transport exceptions) and
wires its clients + transformer chains through a Symfony `ContainerBuilder`. The entry point is the
`MetOffice` facade (`src/MetOffice.php`).

Upstream API essentials:

- **Endpoints:** `GET https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/{hourly,three-hourly,daily}`.
- **Auth:** the API key is sent as the HTTP header `apikey: <key>` (header name literally `apikey`).
- **Query params** (all strings): `latitude`, `longitude`, `dataSource=BD1`,
  `excludeParameterMetadata=true`, `includeLocationName=true`.
- **Response:** GeoJSON — `features[0].properties` holds `location.name`, `modelRunDate` (ISO-8601),
  and `timeSeries` (an array of per-step objects). Each step has a `time` (ISO-8601) plus its weather
  fields. The three resolutions have **three distinct step schemas** (see `src/Model/`).

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first. The style tooling comes from the
private `christianjbrown/php-code-quality-scripts` dev dependency (php-cs-fixer + PHP_CodeSniffer,
**Symfony2 coding standard**); installing it needs SSH/`COMPOSER_AUTH` access to the private repo.

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
`ChristianBrown\MetOffice\Tests\` (`tests/`). A layered design:

- **`MetOffice`** (`src/MetOffice.php`) — the facade/entry point. Constructed with a `string $apiKey`,
  it builds a Symfony `ContainerBuilder` and registers the `ApiClient`, the JSON request sender, the
  three step transformers, three `ForecastTimeStepsTransformer` + `ForecastTransformer` chains, and
  the three API clients (ids are `SERVICE_*` constants on `MetOfficeInterface`, `met_office.` prefix).
  Exposes `getHourlyForecastApi()`, `getThreeHourlyForecastApi()`, `getDailyForecastApi()`.
- **`Api/`** — one client per resolution (`HourlyForecastApi`, `ThreeHourlyForecastApi`,
  `DailyForecastApi`), each constructed with `(JsonApiRequestSenderInterface, ForecastTransformerInterface,
  string $apiKey)`. `getForecast(float $latitude, float $longitude, bool $skipCache = false)` builds
  the query + `apikey` header, calls the sender, guards the `features`/`properties` shape, delegates
  `features[0].properties` to the injected `ForecastTransformer`, and caches by `"latitude,longitude"`.
  Shared constants (header/query keys, `KEY_FEATURES`, `KEY_PROPERTIES`) live on `Api/ApiInterface`.
- **`Model/`** — plain mutable DTOs. `Forecast` holds `locationName`, `modelRunDate` (Unix), and an
  array of `ForecastTimeStepInterface`. `ForecastTimeStepInterface` is the marker (`getTime(): int`)
  implemented by the three step models — `HourlyForecastTimeStep`, `ThreeHourlyForecastTimeStep`,
  `DailyForecastTimeStep` — which have **distinct field sets** (the hourly "instant" schema, the
  three-hourly schema, and the daily day/night schema). Weather codes are stored as `?WeatherType`,
  wind direction as raw `?int` degrees.
- **`Transformer/`** — `ForecastTransformer` builds a `Forecast`, applies optional `location.name` and
  `modelRunDate`, and delegates `timeSeries` to `ForecastTimeStepsTransformer` (a collection wrapping
  one `ForecastTimeStepTransformerInterface`). The three step transformers each implement that
  interface and narrow their return type to their concrete step interface. `WeatherTypeTransformer`
  turns a `WeatherType` into a display name or emoji.
- **`Enums/`** — `WeatherType` (int-backed 0–30 code table, plus `-1` for trace/NA),
  `WindDirection` (string-backed 16-point compass with `WindDirection::fromDegrees(int): self`), and
  `Visibility` (the legacy string visibility bands, retained for completeness).
- **`Exception/`** — a flat hierarchy rooted at `ExceptionInterface extends Throwable`:
  `UnexpectedResponseException extends RuntimeException` (bad/unparseable response) and
  `MissingInputException extends InvalidArgumentException`. A single `catch (ExceptionInterface)`
  covers everything this library throws.

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace.
  There are **no abstract base classes** — the three near-identical API clients and step models each
  stand alone.
- **Constants live on the interface, not the class**: container service ids
  (`MetOfficeInterface::SERVICE_*`), URLs (`API_URL`), request keys (`HEADER_KEY_*`, `QUERY_KEY_*`,
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
2. If it's a new service, register it in `MetOffice::init()` using a new `SERVICE_*` constant.
3. Add a matching `#[CoversClass]` test under `tests/<Layer>/`, doubling all collaborators and
   exercising every guard and optional-field state (absent / wrong-type / valid / zero / whole-number
   float).
4. Run `composer fix-style`, then `composer check-style`, then `composer stan`, then `composer test`
   and **confirm the coverage report is 100%** on lines, paths, methods, and branches.
