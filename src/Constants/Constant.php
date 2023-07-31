<?php

namespace Vcian\LaravelUtils\Constants;

/**
 * Class Constants
 * @package laravelutils\Constants
 */
class Constant
{
    /**
     * Blank declaration / space
     */
    public const ARRAY_DECLARATION = [];
    public const NULL = null;
    public const EMPTY_STRING = '';
    public const BLANK_SPACE = ' ';

    /**
     * Symbols
     */
    public const DASH = "-";
    public const SLASH = "/";
    public const COLON = ":";
    public const DOT = ".";
    public const COMMA = ",";
    public const UNDERSCORE = "_";
    public const EQUALS = "=";
    public const HASH = "#";
    public const ASTERISK = "*";
    public const URL_SEPARATOR = "?";

    /**
     * Boolean
     */
    public const STATUS_TRUE = true;
    public const STATUS_FALSE = false;

    /**
     * Number Pattern
     */
    public const NUMERIC_PATTERN = '/[0-9]+/';

    /**
     * Numbers
     */
    public const ZERO = 0;
    public const ONE = 1;
    public const TWO = 2;
    public const FIVE = 5;
    public const SIX = 6;
    public const TEN = 10;
    public const TWELVE = 12;
    public const THIRTY = 30;
    public const HUNDRED = 100;
    public const DEFAULT_FLOAT = 0.00;

    /**
     * Date & Time
     */
    public const DEFAULT_TIME = '00:00';
    public const DEFAULT_TIMESTAMP = '00:00:00';
    public const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';
    public const UTC = 'UTC';
    public const SECONDS_PER_MINUTE = 60;
    public const SECONDS_PER_HOUR = 3600;

    /**
     * Permissions
     */
    public const FOLDER_PERMISSION = 777;
    public const READ_MODE = 'r';
    public const WRITE_MODE = 'w';

    /**
     * HTTP
     */
    public const HTTP = 'http://';

    /**
     * Alpha - Numeric
     */
    public const NUMBERS = '0123456789';
    public const ALPHABETS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const ALPHA_NUMERIC = '0123456789ABCDEF';

    /**
     * File Storage
     */
    public const DISK_LOCAL = 'local';
    public const DISK_PUBLIC = 'public';
    public const DISK_S3 = 's3';

    public const CSV_FOLDER_PATH = 'uploads/csv/';
    public const CSV_EXTENSION = '.csv';
    public const JPEG_EXTENSION = '.jpeg';
    public const PHP_EXTENSION = 'php';

    public const MIME_JPEG = 'image/jpeg';
    public const MIME_PNG = 'image/png';

    public const FOLDER_SMALL = '/small';
    public const FOLDER_MEDIUM = '/medium';
    public const FOLDER_TEMP = 'temp/';
    public const FOLDER_STORAGE = 'storage/';
    public const FOLDER_SMALL_IMAGE = '/small/';
    public const FOLDER_MEDIUM_IMAGE = '/medium/';

    public const SMALL_WIDTH = 150;
    public const SMALL_HEIGHT = 150;
    public const MEDIUM_WIDTH = 300;
    public const MEDIUM_HEIGHT = 300;

    /**
     * Error code
     */
    public const CODE_200 = 200;
    public const CODE_400 = 400;

    /**
     * DB Queries
     */
    public const PAGINATE_LIMIT = 10;
    public const ORDER_BY_ASC = 'asc';

    /**
     * Regex
     */
    public const SPACE_REGEX = '/\s+/';
    public const NUMBER_REGEX = '/[^0-9]/';

    /**
     * Weight, Length, Distance
     */
    public const LBS_IN_KG = 0.45359237;
    public const INCH_IN_CM = 2.54;
    public const MILE_IN_KM = 1.609344;
    public const DISTANCE_BETWEEN_LAT_LONG = 1.1515;
}