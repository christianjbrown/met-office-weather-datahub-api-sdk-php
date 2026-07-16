<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\MetOffice\ApiInterface as BaseApiInterface;

interface ApiInterface extends BaseApiInterface
{
    public const API_URL_ORDER_FILE_DATA_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/orders/%s/latest/%s/data';
    public const API_URL_ORDER_FILE_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/orders/%s/latest/%s';
    public const API_URL_ORDER_LATEST_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/orders/%s/latest';
    public const API_URL_ORDERS = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/orders';
    public const API_URL_RUNS = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/runs';
    public const API_URL_RUNS_BY_MODEL_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/atmospheric-models/1.0.0/runs/%s';
    public const HEADER_KEY_ACCEPT = 'Accept';
    public const HEADER_VALUE_ACCEPT_GRIB = 'application/x-grib';
    public const HEADER_VALUE_ACCEPT_JSON = 'application/json';
    public const KEY_FILE = 'file';
    public const KEY_FILE_DETAILS = 'fileDetails';
    public const KEY_FILES = 'files';
    public const KEY_ORDER = 'order';
    public const KEY_ORDER_DETAILS = 'orderDetails';
    public const KEY_ORDERS = 'orders';
    public const KEY_PARAMETER_DETAILS = 'parameterDetails';
    public const KEY_RUNS = 'runs';
    public const QUERY_KEY_DATA_SPEC = 'dataSpec';
    public const QUERY_KEY_DETAIL = 'detail';
    public const QUERY_KEY_RUNFILTER = 'runfilter';
    public const UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';
}
