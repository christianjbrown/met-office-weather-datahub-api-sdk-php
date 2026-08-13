# Blended Probabilistic Forecast: v1 → v2 parameter names

Parameter ids were renamed wholesale for BPF **v2** — snake_case became camelCase, and many names
gained a height/level suffix (`1p5m`, `10m`) or had their components reordered. This table is the full
mapping, transcribed from the Met Office's
[v1 → v2 parameter name changes PDF](https://datahub.metoffice.gov.uk/downloads/bpf-v2-parameter-name-changes).

This library treats parameter names as **opaque strings** — nothing here is encoded in the SDK. The table
matters only when updating the names you pass to `DataQuery`, or when reading older code written against v1.
The authoritative list for any collection is always its own `getParameters()` map, which is generated from
the live API rather than from this file.

`.` is encoded as `p` throughout (`1p5m` = 1.5 m, `5p555556e-7ms-1` = 5.555556e-7 m s⁻¹).

**157 mappings.**

**Verified against the live API on 2026-08-13.** Every one of the 157 v2 keys below exists in the live v2
`parameter_names` map, and conversely the live API exposed no parameter outside this table — the union
across all four collections was exactly these 157 names.

### Corrections to the source PDF

The PDF lists **159** rows, two of which are spurious. Two v1 labels each appear twice, mapping to v2 keys
differing only by `Sum`; the non-`Sum` variants do not exist in the live API and have been omitted here:

| Omitted (not in the live API) | Correct v2 key |
| --- | --- |
| `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mPt01h` | `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mSumPt01h` |
| `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mPt03h` | `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mSumPt03h` |

Both surviving keys live in `uk-spot-probabilities`.

One caveat on volatility: the parameter counts for the two UK collections were each one higher when first
sampled on 2026-08-12 (`uk-spot-percentiles` 78 → 77, `uk-spot-probabilities` 79 → 78), so the live set is
not perfectly static. Always prefer a collection's own `getParameters()` map over this file.

| V1 parameter label | V2 parameter key |
| --- | --- |
| `air_pressure_at_sea_level` | `airPressureAtSeaLevel` |
| `air_temperature` | `airTemperature1p5m` |
| `air_temperature_maximum_PT12H` | `airTemperature1p5mMaximumPt12h` |
| `air_temperature_minimum_PT12H` | `airTemperature1p5mMinimumPt12h` |
| `cloud_area_fraction` | `cloudAreaFraction` |
| `cloud_base_height_assuming_only_consider_cloud_area_fraction_greater_than_2p5_oktas` | `cloudBaseHeightAssumingOnlyConsiderCloudAreaFractionGreaterThan2p5Oktas` |
| `cloud_base_height_assuming_only_consider_cloud_area_fraction_greater_than_4p5_oktas` | `cloudBaseHeightAssumingOnlyConsiderCloudAreaFractionGreaterThan4p5Oktas` |
| `duration_of_sunshine_sum_PT24H` | `durationOfSunshineSumPt24h` |
| `feels_like_temperature` | `feelsLikeTemperature1p5m` |
| `fraction_of_time_classified_as_wet_0pt003m_0pt0ms-1_PT24H` | `fractionOfTimeClassifiedAsWet0ms-10p003mPt24h` |
| `fraction_of_time_classified_as_wet_0pt003m_1pt1111111E-6ms-1_PT24H` | `fractionOfTimeClassifiedAsWet1p1111111e-6ms-10p003mPt24h` |
| `fraction_of_time_classified_as_wet_0pt003m_5pt555556E-7ms-1_PT24H` | `fractionOfTimeClassifiedAsWet5p555556e-7ms-10p003mPt24h` |
| `fraction_of_time_classified_as_wet_3pt0E-4m_0pt0ms-1_PT24H` | `fractionOfTimeClassifiedAsWet0ms-13p0e-4mPt24h` |
| `fraction_of_time_classified_as_wet_3pt0E-4m_1pt1111111E-6ms-1_PT24H` | `fractionOfTimeClassifiedAsWet1p1111111e-6ms-13p0e-4mPt24h` |
| `fraction_of_time_classified_as_wet_3pt0E-4m_5pt555556E-7ms-1_PT24H` | `fractionOfTimeClassifiedAsWet5p555556e-7ms-13p0e-4mPt24h` |
| `low_type_cloud_area_fraction` | `lowTypeCloudAreaFraction` |
| `lwe_precipitation_rate_in_vicinity_10000_m` | `lwePrecipitationRateInVicinity10000m` |
| `lwe_precipitation_rate` | `lwePrecipitationRate` |
| `lwe_sleetfall_rate` | `lweSleetfallRate` |
| `lwe_snowfall_rate` | `lweSnowfallRate` |
| `lwe_thickness_of_freezing_rainfall_amount_sum_PT01H` | `lweThicknessOfFreezingRainfallAmountSumPt01h` |
| `lwe_thickness_of_freezing_rainfall_amount_sum_PT03H` | `lweThicknessOfFreezingRainfallAmountSumPt03h` |
| `lwe_thickness_of_graupel_and_hail_fall_amount_sum_PT01H` | `lweThicknessOfGraupelAndHailFallAmountSumPt01h` |
| `lwe_thickness_of_graupel_and_hail_fall_amount_sum_PT03H` | `lweThicknessOfGraupelAndHailFallAmountSumPt03h` |
| `lwe_thickness_of_precipitation_amount_in_vicinity_10000_m_sum_PT01H` | `lweThicknessOfPrecipitationAmountInVicinity10000mSumPt01h` |
| `lwe_thickness_of_precipitation_amount_in_vicinity_10000_m_sum_PT03H` | `lweThicknessOfPrecipitationAmountInVicinity10000mSumPt03h` |
| `lwe_thickness_of_precipitation_amount_sum_PT01H` | `lweThicknessOfPrecipitationAmountSumPt01h` |
| `lwe_thickness_of_precipitation_amount_sum_PT03H` | `lweThicknessOfPrecipitationAmountSumPt03h` |
| `lwe_thickness_of_precipitation_amount_sum_PT06H` | `lweThicknessOfPrecipitationAmountSumPt06h` |
| `lwe_thickness_of_precipitation_amount_sum_PT12H` | `lweThicknessOfPrecipitationAmountSumPt12h` |
| `lwe_thickness_of_precipitation_amount_sum_PT24H` | `lweThicknessOfPrecipitationAmountSumPt24h` |
| `lwe_thickness_of_precipitation_amount_sum_PT48H` | `lweThicknessOfPrecipitationAmountSumPt48h` |
| `lwe_thickness_of_sleetfall_amount_sum_PT01H` | `lweThicknessOfSleetfallAmountSumPt01h` |
| `lwe_thickness_of_sleetfall_amount_sum_PT03H` | `lweThicknessOfSleetfallAmountSumPt03h` |
| `lwe_thickness_of_snowfall_amount_sum_PT01H` | `lweThicknessOfSnowfallAmountSumPt01h` |
| `lwe_thickness_of_snowfall_amount_sum_PT03H` | `lweThicknessOfSnowfallAmountSumPt03h` |
| `probability_of_air_pressure_at_sea_level_above_threshold` | `probabilityOfAirPressureAtSeaLevelAboveThreshold` |
| `probability_of_air_temperature_above_threshold_maximum_PT12H` | `probabilityOfAirTemperatureAboveThreshold1p5mMaximumPt12h` |
| `probability_of_air_temperature_above_threshold_minimum_PT12H` | `probabilityOfAirTemperatureAboveThreshold1p5mMinimumPt12h` |
| `probability_of_air_temperature_above_threshold` | `probabilityOfAirTemperatureAboveThreshold1p5m` |
| `probability_of_cloud_area_fraction_above_threshold` | `probabilityOfCloudAreaFractionAboveThreshold` |
| `probability_of_cloud_base_height_assuming_only_consider_cloud_area_fraction_greater_than_2p5_oktas_below_threshold` | `probabilityOfCloudBaseHeightAssumingOnlyConsiderCloudAreaFractionGreaterThan2p5OktasBelowThreshold` |
| `probability_of_cloud_base_height_assuming_only_consider_cloud_area_fraction_greater_than_4p5_oktas_below_threshold` | `probabilityOfCloudBaseHeightAssumingOnlyConsiderCloudAreaFractionGreaterThan4p5OktasBelowThreshold` |
| `probability_of_feels_like_temperature_above_threshold` | `probabilityOfFeelsLikeTemperatureAboveThreshold1p5m` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_0pt003m_0pt0ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold0ms-10p003mPt24h` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_0pt003m_1pt1111111E-6ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold1p1111111e-6ms-10p003mPt24h` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_0pt003m_5pt555556E-7ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold5p555556e-7ms-10p003mPt24h` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_3pt0E-4m_0pt0ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold0ms-13p0e-4mPt24h` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_3pt0E-4m_1pt1111111E-6ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold1p1111111e-6ms-13p0e-4mPt24h` |
| `probability_of_fraction_of_time_classified_as_wet_above_threshold_3pt0E-4m_5pt555556E-7ms-1_PT24H` | `probabilityOfFractionOfTimeClassifiedAsWetAboveThreshold5p555556e-7ms-13p0e-4mPt24h` |
| `probability_of_low_type_cloud_area_fraction_above_threshold` | `probabilityOfLowTypeCloudAreaFractionAboveThreshold` |
| `probability_of_lwe_precipitation_rate_above_threshold` | `probabilityOfLwePrecipitationRateAboveThreshold` |
| `probability_of_lwe_precipitation_rate_in_vicinity_above_threshold_10000_m` | `probabilityOfLwePrecipitationRateInVicinityAboveThreshold10000m` |
| `probability_of_lwe_sleetfall_rate_above_threshold` | `probabilityOfLweSleetfallRateAboveThreshold` |
| `probability_of_lwe_snowfall_rate_above_threshold` | `probabilityOfLweSnowfallRateAboveThreshold` |
| `probability_of_lwe_thickness_of_freezing_rainfall_amount_above_threshold_sum_PT01H` | `probabilityOfLweThicknessOfFreezingRainfallAmountAboveThresholdSumPt01h` |
| `probability_of_lwe_thickness_of_freezing_rainfall_amount_above_threshold_sum_PT03H` | `probabilityOfLweThicknessOfFreezingRainfallAmountAboveThresholdSumPt03h` |
| `probability_of_lwe_thickness_of_graupel_and_hail_fall_amount_above_threshold_sum_PT01H` | `probabilityOfLweThicknessOfGraupelAndHailFallAmountAboveThresholdSumPt01h` |
| `probability_of_lwe_thickness_of_graupel_and_hail_fall_amount_above_threshold_sum_PT03H` | `probabilityOfLweThicknessOfGraupelAndHailFallAmountAboveThresholdSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT01H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt01h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT03H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT06H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt06h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT12H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT24H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_above_threshold_sum_PT48H` | `probabilityOfLweThicknessOfPrecipitationAmountAboveThresholdSumPt48h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_variable_vicinity_above_threshold_10000_m_sum_PT01H` | `probabilityOfLweThicknessOfPrecipitationAmountInVariableVicinityAboveThreshold10000mSumPt01h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_variable_vicinity_above_threshold_10000_m_sum_PT03H` | `probabilityOfLweThicknessOfPrecipitationAmountInVariableVicinityAboveThreshold10000mSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_10000_m_sum_PT01H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold10000mSumPt01h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_10000_m_sum_PT03H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold10000mSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT01H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum1hourPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT01H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum1hourPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT03H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum3hoursPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT03H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum3hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT06H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum6hoursPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT06H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum6hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_14000_m_PT12H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mMaximumSum12hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT01H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum1hourPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT01H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum1hourPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT03H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum3hoursPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT03H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum3hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT06H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum6hoursPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT06H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum6hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_maximum_sum_30000_m_PT12H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mMaximumSum12hoursPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT01H_W001H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt01h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT03H_W003H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT06H_W006H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt06h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT12H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT24H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_14000_m_PT48H_W048H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold14000mSumPt48h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT01H_W001H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt01h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT03H_W003H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt03h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT06H_W006H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt06h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT12H_W012H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt12h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT24H_W024H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt24h` |
| `probability_of_lwe_thickness_of_precipitation_amount_in_vicinity_above_threshold_sum_30000_m_PT48H_W048H` | `probabilityOfLweThicknessOfPrecipitationAmountInVicinityAboveThreshold30000mSumPt48h` |
| `probability_of_lwe_thickness_of_sleetfall_amount_above_threshold_sum_PT01H` | `probabilityOfLweThicknessOfSleetfallAmountAboveThresholdSumPt01h` |
| `probability_of_lwe_thickness_of_sleetfall_amount_above_threshold_sum_PT03H` | `probabilityOfLweThicknessOfSleetfallAmountAboveThresholdSumPt03h` |
| `probability_of_lwe_thickness_of_snowfall_amount_above_threshold_sum_PT01H` | `probabilityOfLweThicknessOfSnowfallAmountAboveThresholdSumPt01h` |
| `probability_of_lwe_thickness_of_snowfall_amount_above_threshold_sum_PT03H` | `probabilityOfLweThicknessOfSnowfallAmountAboveThresholdSumPt03h` |
| `probability_of_number_of_lightning_flashes_per_unit_area_above_threshold_Sum_PT01H` | `probabilityOfNumberOfLightningFlashesPerUnitAreaAboveThresholdSumPt01h` |
| `probability_of_number_of_lightning_flashes_per_unit_area_above_threshold_Sum_PT03H` | `probabilityOfNumberOfLightningFlashesPerUnitAreaAboveThresholdSumPt03h` |
| `probability_of_number_of_lightning_flashes_per_unit_area_in_vicinity_above_threshold_15000_m_PT01H` | `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mSumPt01h` |
| `probability_of_number_of_lightning_flashes_per_unit_area_in_vicinity_above_threshold_15000_m_PT03H` | `probabilityOfNumberOfLightningFlashesPerUnitAreaInVicinityAboveThreshold15000mSumPt03h` |
| `probability_of_rainfall_rate_above_threshold` | `probabilityOfRainfallRateAboveThreshold` |
| `probability_of_relative_humidity_above_threshold` | `probabilityOfRelativeHumidityAboveThreshold1p5m` |
| `probability_of_thickness_of_rainfall_amount_above_threshold_sum_PT01H` | `probabilityOfThicknessOfRainfallAmountAboveThresholdSumPt01h` |
| `probability_of_thickness_of_rainfall_amount_above_threshold_sum_PT03H` | `probabilityOfThicknessOfRainfallAmountAboveThresholdSumPt03h` |
| `probability_of_ultraviolet_index_above_threshold_maximum_PT24H` | `probabilityOfUltravioletIndexAboveThresholdMaximumPt24h` |
| `probability_of_ultraviolet_index_above_threshold` | `probabilityOfUltravioletIndexAboveThreshold` |
| `probability_of_visibility_in_air_below_threshold` | `probabilityOfVisibilityInAirBelowThreshold1p5m` |
| `probability_of_visibility_in_air_in_vicinity_below_threshold_10000_m` | `probabilityOfVisibilityInAirInVicinityBelowThreshold1p5m10000m` |
| `probability_of_wind_speed_above_threshold_mean_PT24H` | `probabilityOfWindSpeedAboveThreshold10mMeanPt24h` |
| `probability_of_wind_speed_above_threshold` | `probabilityOfWindSpeedAboveThreshold10m` |
| `probability_of_wind_speed_of_gust_above_threshold_maximum_PT01H` | `probabilityOfWindSpeedOfGustAboveThreshold10mMaximumPt01h` |
| `probability_of_wind_speed_of_gust_above_threshold_maximum_PT03H` | `probabilityOfWindSpeedOfGustAboveThreshold10mMaximumPt03h` |
| `probability_of_wind_speed_of_gust_above_threshold_maximum_PT24H` | `probabilityOfWindSpeedOfGustAboveThreshold10mMaximumPt24h` |
| `rainfall_rate` | `rainfallRate` |
| `relative_humidity` | `relativeHumidity1p5m` |
| `thickness_of_rainfall_amount_sum_PT01H` | `thicknessOfRainfallAmountSumPt01h` |
| `thickness_of_rainfall_amount_sum_PT03H` | `thicknessOfRainfallAmountSumPt03h` |
| `ultraviolet_index_maximum_PT24H` | `ultravioletIndexMaximumPt24h` |
| `ultraviolet_index` | `ultravioletIndex` |
| `visibility_in_air_in_vicinity_10000_m` | `visibilityInAirInVicinity1p5m10000m` |
| `visibility_in_air` | `visibilityInAir1p5m` |
| `weather_code_mode_1_hour_PT01H` | `weatherCodeMode1hourPt01h` |
| `weather_code_mode_1_hour_PT02H` | `weatherCodeMode1hourPt02h` |
| `weather_code_mode_1_hour_PT03H` | `weatherCodeMode1hourPt03h` |
| `weather_code_mode_1_hour_PT04H` | `weatherCodeMode1hourPt04h` |
| `weather_code_mode_1_hour_PT05H` | `weatherCodeMode1hourPt05h` |
| `weather_code_mode_1_hour_PT06H` | `weatherCodeMode1hourPt06h` |
| `weather_code_mode_1_hour_PT07H` | `weatherCodeMode1hourPt07h` |
| `weather_code_mode_1_hour_PT08H` | `weatherCodeMode1hourPt08h` |
| `weather_code_mode_1_hour_PT09H` | `weatherCodeMode1hourPt09h` |
| `weather_code_mode_1_hour_PT10H` | `weatherCodeMode1hourPt10h` |
| `weather_code_mode_1_hour_PT11H` | `weatherCodeMode1hourPt11h` |
| `weather_code_mode_1_hour_PT12H` | `weatherCodeMode1hourPt12h` |
| `weather_code_mode_1_hour_PT13H` | `weatherCodeMode1hourPt13h` |
| `weather_code_mode_1_hour_PT14H` | `weatherCodeMode1hourPt14h` |
| `weather_code_mode_1_hour_PT15H` | `weatherCodeMode1hourPt15h` |
| `weather_code_mode_1_hour_PT16H` | `weatherCodeMode1hourPt16h` |
| `weather_code_mode_1_hour_PT17H` | `weatherCodeMode1hourPt17h` |
| `weather_code_mode_1_hour_PT18H` | `weatherCodeMode1hourPt18h` |
| `weather_code_mode_1_hour_PT19H` | `weatherCodeMode1hourPt19h` |
| `weather_code_mode_1_hour_PT20H` | `weatherCodeMode1hourPt20h` |
| `weather_code_mode_1_hour_PT21H` | `weatherCodeMode1hourPt21h` |
| `weather_code_mode_1_hour_PT22H` | `weatherCodeMode1hourPt22h` |
| `weather_code_mode_1_hour_PT23H` | `weatherCodeMode1hourPt23h` |
| `weather_code_mode_1_hour_PT24H` | `weatherCodeMode1hourPt24h` |
| `weather_code_mode_3_hour_PT24H` | `weatherCodeMode3hourPt24h` |
| `weather_code_PT01H` | `weatherCodePt01h` |
| `weather_code_PT03H` | `weatherCodePt03h` |
| `wind_from_direction` | `windFromDirection10mMean` |
| `wind_speed_mean_PT24H` | `windSpeed10mMeanPt24h` |
| `wind_speed_of_gust_maximum_PT01H` | `windSpeedOfGust10mMaximumPt01h` |
| `wind_speed_of_gust_maximum_PT03H` | `windSpeedOfGust10mMaximumPt03h` |
| `wind_speed_of_gust_maximum_PT24H` | `windSpeedOfGust10mMaximumPt24h` |
| `wind_speed` | `windSpeed10m` |
