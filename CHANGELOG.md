# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2026-09-28

### Added

- `getForecast()` on the Site-Specific (Global Spot) forecast clients takes an optional third argument.
  Pass `true` to receive per-parameter metadata (unit label and symbol, description, type) through
  `getParameters()`.
- Global Spot forecasts carry the distance from the requested point in metres, the resolved location's
  `licence` attribution and the elevation of the resolved point.
- Observation (Land) nearest lookups, `getByCoordinates()` and `getByGeohash()`, take an optional `$max`
  (1 to 5) to return more than one nearest location.
- Atmospheric Models: `getOrders()` takes an optional `$detail` (`MINIMAL` or `FULL`), and both runs
  methods take an optional `$sort`.
- Map Images: `getRuns()` takes an optional `$sort`, and `getOrderFileData()` takes optional
  `$includeLand` and `$legend` arguments.

All new arguments are optional and appended, and new model fields default to null or empty, so existing
calls keep working.

## [1.0.0] - 2026-09-28

First stable release.

### Added

- `MetOffice`, an entry point with one facade per Met Office Weather DataHub API. The client is read-only
  and returns typed model objects rather than raw GeoJSON or CoverageJSON.
- Site-Specific (Global Spot): hourly, three-hourly and daily point forecasts for a latitude and longitude.
- Blended Probabilistic Forecast (v2): collections, instances, locations and position queries returning
  typed CoverageJSON, with an optional `DataQuery` filter.
- Observation (Land): nearest observation locations by coordinates or geohash, and the past 48 hours of
  hourly observations for a geohash, cached per geohash.
- Atmospheric Models: model runs, orders and files as typed metadata, and the raw GRIB bytes of a file.
- Map Images: model runs, orders and files as typed metadata, and the raw PNG bytes of a file.
- An optional, last `ApiHostInterface` constructor argument on each API facade, so every product's base URL
  can be pointed somewhere other than production.
- A single exception hierarchy, so callers do not depend on the underlying HTTP client.

[Unreleased]: https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/christianjbrown/met-office-weather-datahub-api-sdk-php/releases/tag/v1.0.0
