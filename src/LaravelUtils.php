<?php

namespace Vcian\LaravelUtils;

use DateTime;
use Exception;
use DOMDocument;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Vcian\LaravelUtils\Constants\Constant;

class LaravelUtils
{
/* =========================================== Get app name helper ======================================= */

    /**
    * Helper to grab the application name.
    *
    * @return string
    */
    public static function appName() : string
    {
        try {
            return config('app.name');
            
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

/* =========================================== Laravel Auth Helpers ======================================= */

    /**
    * Get Logged in user
    * 
    * @return mixed
    */
    public static function loggedInUser() : mixed
    {
        try {
            return Auth::user() ?? Constant::EMPTY_STRING;
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Checks user login or not
    * 
    * @return bool
    */
    public static function checkAuth() : bool
    {
        try {
            return auth()->check();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* =========================================== Encryption & Decryption Helpers ============================= */
    
    /**
    * Encrypts given value.
    *
    * @param $value
    * 
    * @return mixed
    */
    public static function encryption($value) : mixed
    {
        try {
            return encrypt($value);

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Decrypts given value.
    *
    * @param $value
    * 
    * @return mixed
    */
    public static function decryption($value) : mixed
    {
        try {
            return decrypt($value);

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

/* =========================================== Database Helpers ============================================ */

    /**
    * Check Database Connection
    * 
    * @return bool
    */
    public static function checkDbConnection() : bool
    {
        try {
            DB::connection()->reconnect();

            return Constant::STATUS_TRUE;
        } catch (Exception $ex) {
            Log::error($ex);

            return Constant::STATUS_FALSE;
        }
    }

    /**
    * Print Query
    * 
    * @param $query
    * 
    * @return string
    */
    public static function printQuery($query) : string
    {
        try {
            if (!empty($query)) {
                $addSlashes = str_replace('?', "'?'", $query->toSql());

                return vsprintf(str_replace('?', '%s', $addSlashes), $query->getBindings());
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return Constant::EMPTY_STRING;
    }

    /**
    * Select query
    * 
    * @param string $table
    * @param array $columns
    * @param array $conditions
    * @param array $orderBy
    * @param $limit
    * 
    * @return mixed
    */
    public static function selectQuery($table, $columns = [Constant::ASTERISK], $conditions = Constant::ARRAY_DECLARATION, $orderBy = Constant::ARRAY_DECLARATION, $limit = Constant::NULL) : mixed
    {
        try {
            $query = DB::table($table)->select($columns);
                
            foreach ($conditions as $condition) {
                $query->where($condition[Constant::ZERO], $condition[Constant::ONE], $condition[Constant::TWO]);
            }
                
            foreach ($orderBy as $order) {
                $query->orderBy($order[Constant::ZERO], $order[Constant::ONE]);
            }
                
            if ($limit) {
                $query->limit($limit);
            }
                
            return $query->get();
                
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Inserts record 
    * 
    * @param $table
    * @param $data
    * 
    * @return mixed
    */
    public static function insertQuery($table, $data) : mixed
    {
        try {
            return DB::table($table)->insert($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Updates record
    * 
    * @param $table
    * @param $data
    * @param $conditions
    * 
    * @return mixed
    */
    public static function updateQuery($table, $data, $conditions) : mixed
    {
        try {
            $query = DB::table($table);

            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }

            return $query->update($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Deletes record
    * 
    * @param $table
    * @param $conditions
    * 
    * @return mixed
    */
    public static function deleteQuery($table, $conditions) : mixed
    {
        try {
            $query = DB::table($table);

            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }

            return $query->delete();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Filter query with condition
    * 
    * @param $table
    * @param $column
    * @param $operator
    * @param $value
    * 
    * @return mixed
    */
    public static function filterQuery($table, $column, $operator, $value) : mixed
    {
        try {
            return DB::table($table)->where($column, $operator, $value)->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get records in specific order
    * 
    * @param $table
    * @param $column
    * @param string $direction
    * 
    * @return mixed
    */
    public static function orderResults($table, $column, $direction = Constant::ORDER_BY_ASC) : mixed
    {
        try {
            return DB::table($table)->orderBy($column, $direction)->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Counts number of records in table
    * 
    * @param $table
    * 
    * @return mixed
    */
    public static function countResults($table) : mixed
    {
        try {
            return DB::table($table)->count();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Join query for tables
    * 
    * @param $table1
    * @param $table2
    * @param $column1
    * @param $column2
    * 
    * @return mixed
    */
    public static function joinTables($table1, $table2, $column1, $column2) : mixed
    {
        try {
            return DB::table($table1)->join($table2, $column1, Constant::EQUALS, $column2)->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get paginate results
    * 
    * @param $query
    * @param integer $perPage
    * 
    * @return mixed
    */
    public static function getPaginatedResults($query, $perPage = Constant::PAGINATE_LIMIT) : mixed
    {
        try {
            return $query->paginate($perPage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* =========================================== Laravel Custom Route Helpers ================================= */

    /**
    * Loops through a folder and requires all PHP files
    * Searches sub-directories as well.
    *
    * @param $folder
    * 
    * @return void
    */
    public static function includeRouteFiles($folder) : void
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === Constant::PHP_EXTENSION) {
                    require $it->key();
                }
                $it->next();
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Converts querystring params to array and use it as route params and returns URL.
    * 
    * @param $url
    * @param $urlType
    * @param $separator
    * 
    * @return string
    */
    public static function getRouteUrl($url, $urlType = 'route', $separator = Constant::URL_SEPARATOR) : string
    {
        $routeUrl = Constant::EMPTY_STRING;

        try {
            if (!empty($url)) {
                if ($urlType == 'route') {

                    if (strpos($url, $separator) !== Constant::STATUS_FALSE) {
                        $urlArray = explode($separator, $url);
                        $url = $urlArray[Constant::ZERO];
                        parse_str($urlArray[Constant::ONE], $params);
                        $routeUrl = route($url, $params);
                    } else {
                        $routeUrl = route($url);
                    }
                } else {
                    $routeUrl = $url;
                }
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $routeUrl;
    }

/* =========================================== Auto Generation Helpers ====================================== */

    /**
    * Generate password
    *
    * @return string
    */
    public static function autoGeneratePassword() : string
    {
        try {
            $digits    = Constant::NUMBERS;
            $uppercase = Constant::ALPHABETS;
            $password  = str_shuffle(
                substr(str_shuffle($digits), Constant::ZERO, Constant::ONE) .
                substr(str_shuffle($uppercase), Constant::ZERO, Constant::ONE) .
                substr(str_shuffle($digits . $uppercase), Constant::ZERO, Constant::FIVE)
            );
                
            return $password;
        } catch (Exception $ex) {
            Log::error($ex);
                
            return Constant::ZERO;
        }
    }

    /**
    * Generates OTP
    * 
    * @param int $length
    * 
    * @return string
    */
    public static function generateOtp($length = Constant::SIX) : string
    {
        $pool = Constant::NUMBERS;
        return substr(str_shuffle(str_repeat($pool, $length)), Constant::ZERO, $length);
    }

    /**
    * Get server user agent
    *
    * @return mixed
    */
    public static function getUserAgent() : mixed
    {
        try {
            return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : Constant::NULL;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* ======================================= API Connection/Response Helpers ================================== */

    /**
    * Generate api token
    *
    * @return string
    */
    public static function generateApiToken() : string
    {
        $apiToken = Constant::EMPTY_STRING;

        try {
            $apiToken = implode(Constant::EMPTY_STRING, str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), Constant::ZERO, Constant::THIRTY), Constant::SIX));

        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $apiToken;
    }

    /**
    * CURL request
    * 
    * @param $url
    * @param $method
    * @param array $data
    * @param array $headers // pass Authorization and content-type
    * 
    * @return mixed
    */
    public static function callAPI($url, $method, $data = Constant::ARRAY_DECLARATION, $headers = Constant::ARRAY_DECLARATION) : mixed
    {
        try {
            $curl = curl_init();

            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, Constant::ONE);
                    if (!empty($data)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                    }
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    if (!empty($data)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                    }
                    break;
                case "DELETE":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                default:
                    if (!empty($data)) {
                        $url = sprintf("%s?%s", $url, http_build_query($data));
                    }
            }

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, Constant::STATUS_TRUE);

            if (!empty($headers)) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            }
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $response = array('error' => curl_error($curl));
            }
            curl_close($curl);

            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Returns Json Response from api
    * 
    * @param $data
    * @param int $statusCode
    * 
    * @return JsonResponse
    */
    public static function jsonResponseFromAPI($data, $statusCode = Constant::CODE_200) : JsonResponse
    {
        try {
            return response()->json($data, $statusCode);
        }catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* ============================================= CSS Helpers =============================================== */

    /**
    * Get css and js path
    *
    * @param $path
    *
    * @return string
    */
    public static function customAsset($path) : string
    {
        try {
            return asset($path);

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Returns Active Menu
    * 
    * @param string $route
    * @param string $page
    * 
    * @return string
    */
    public static function activeMenu(string $route, string $page) : string
    {
        $response = Constant::EMPTY_STRING;

        try {
            if (request()->url() == $route || request()->is($page . '/*')) {
                $response = 'menu-item-active menu-item-open'; //You can change css class here
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $response;
    }

    /**
    * Generate random color
    *
    * @return string
    */
    public static function getRandomColor() : string
    {
        try {
            $letters = Constant::ALPHA_NUMERIC;
            $color = Constant::HASH;

            for ($i = Constant::ZERO; $i < Constant::SIX; $i++) {
                $color .= $letters[rand(0, 15)];
            }

            return $color;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* =========================================== Link Formating Helpers ======================================= */

    /**
    * Link Formating
    * 
    * @param $link
    * 
    * @return string
    */
    public static function linkFormatting($link) : string
    {
        try {
            if (!preg_match("~^(?:f|ht)tps?://~i", $link)) {
                $link = Constant::HTTP . $link;
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $link;
    }

/* =========================================== Array Search Helpers ======================================== */

    /**
    * Search in Array
    * 
    * @param $array
    * @param $keyword
    * 
    * @return array
    */
    public static function arrayPartialSearch($array, $keyword) : array
    {
        $found = Constant::ARRAY_DECLARATION;

        try {
            // Loop through each item and check for a match.
            foreach ($array as $stringKey => $stringValue) {

                // If found somewhere inside the string, add.
                if (strpos($stringKey, $keyword) !== Constant::STATUS_FALSE) {
                    $found[$stringKey] = $stringValue;
                }
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $found;
    }

/* =========================================== Data Conversion Helpers ====================================== */

    /**
    * Convert object to array
    * 
    * @param $collection
    * 
    * @return array|\Illuminate\Support\Collection
    */
    public static function objectToArray($collection) : array
    {
        $collectionArray = Constant::ARRAY_DECLARATION;

        try {
            foreach ($collection as $key => $value) {
                $collectionArray[] = [
                    'id' => $key,
                    'value' => html_entity_decode($value),
                ];
            }

            return $collectionArray;
        } catch (Exception $ex) {
            Log::error($ex);

            return $collectionArray;
        }
    }

    /**
    * Get Json to array
    * 
    * @param string $name
    * 
    * @return array
    */
    public static function jsonToArray($names) : array
    {
        $nameArray = Constant::ARRAY_DECLARATION;

        try {
            $names = json_decode($names);
            
            if (!empty($names)) {
                // Create all tags (unassociate)
                foreach ($names as $name) {
                    array_push($nameArray, $name->value);
                }
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }
            
        return $nameArray;
    }

    /**
    * CSV to ARRAY (Convert file CSV to array)
    * 
    * @param string $filename
    * 
    * @return mixed
    */
    public static function csvToArray($filename = Constant::EMPTY_STRING) : mixed
    {
        $main = Constant::ARRAY_DECLARATION;
        $data = Constant::ARRAY_DECLARATION;
        $allArr = Constant::ARRAY_DECLARATION;

        try {
            $path = base_path(Constant::CSV_FOLDER_PATH . $filename . Constant::CSV_EXTENSION);
            $file = fopen($path, Constant::READ_MODE) or die(print_r(error_get_last(), Constant::STATUS_TRUE));
                
            while (!feof($file)) {
                $main[] = fgetcsv($file);
            }
            $main = array_filter($main);
                
            foreach ($main as $value) {
                $i = Constant::ZERO;
                
                foreach ($value as $v) {
                    $dk = mb_strtolower(preg_replace("/[^a-z0-9_-]+/i", Constant::EMPTY_STRING, str_replace(Constant::BLANK_SPACE, Constant::DASH, $main[Constant::ZERO][$i])));

                    $data[$dk] = $v;
                    $i++;
                }
                $allArr[] = $data;
            }
            unset($allArr[Constant::ZERO]);
            fclose($file);
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $allArr;
    }

    /**
    * Array to CSV file
    * 
    * @param array $data
    * @param string $fileName
    * 
    * @return void
    */
    public static function arrayToCsv(array $data, string $fileName) : void
    {
        try {
            // Open a temporary file to write the CSV data
            $temp = fopen('temp', Constant::WRITE_MODE);

            // Write the header row to the CSV
            fputcsv($temp, array_keys($data[Constant::ZERO]));

            // Write the data rows to the CSV
            foreach ($data as $row) {
                fputcsv($temp, $row);
            }

            // Move the file pointer back to the beginning of the file
            rewind($temp);

            // Create a Laravel File object from the temporary file
            $file = new File(stream_get_meta_data($temp)['uri']);

            // Store the file in Laravel storage
            Storage::put($fileName, $file);

            // Close the temporary file
            fclose($temp);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get Current Activate Language
    * 
    * @return string
    */
    public static function currentActivateLanguage() : string
    {
        try {
            return App::getLocale();

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

/* =========================================== Date & Time Helpers ========================================= */

    /**
    * Returns current timestamp in the specified timezone
    * 
    * @param $timezone
    * 
    * @return string
    */
    public static function getCurrentTimestamp($timezone = Constant::UTC) : string
    {
        try {
            return Carbon::now($timezone)->timestamp;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Returns current year
    * 
    * @return string
    */
    public static function getCurrentYear() : string
    {
        try {
            return date('Y');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Returns current month
    * 
    * @return string
    */
    public static function getCurrentMonth() : string
    {
        try {
            return date('m');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Returns current date
    * 
    * @return string
    */
    public static function getCurrentDate() : string
    {
        try {
            return date('d');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Sum of time (Calculation of time)
    * 
    * @param array $times
    * 
    * @return string
    */
    public static function timeSumCalculation($times = Constant::ARRAY_DECLARATION) : string
    {
        $timeSum = Constant::DEFAULT_TIME;
        $minutes = Constant::ZERO;

        try {
            if (!empty($times)) {
                foreach ($times as $time) {
                    if ($time != Constant::EMPTY_STRING) {
                        list($hour, $minute) = explode(Constant::COLON, $time);
                        $minutes += $hour * Constant::SECONDS_PER_MINUTE;
                        $minutes += $minute;
                    }
                }
                $hours = floor($minutes / Constant::SECONDS_PER_MINUTE);
                $minutes -= $hours * Constant::SECONDS_PER_MINUTE;

                // returns the time already formatted
                $timeSum = sprintf('%02d:%02d', $hours, $minutes);
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $timeSum;
    }

    /**
    * Get hours Difference
    * 
    * @param string $createdDate
    * 
    * @return int
    */
    public static function getHoursDifference($createdDate = Constant::EMPTY_STRING) : int
    {
        $hoursDiff = Constant::ZERO;

        try {
            $hoursDiff = Carbon::parse($createdDate)->diffInHours();
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $hoursDiff;
    }

    /**
    * Get days difference 
    * 
    * @param $date1
    * @param $date2
    *
    * @return int
    */
    public static function getDaysDiff($date1, $date2) : int
    {
        $interval = Constant::EMPTY_STRING;

        try {
            $interval = (new DateTime($date1))->diff(new DateTime($date2));
                
            return $interval->days;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Date range
    * 
    * @param  $startDate
    * @param  $endDate
    * @param  $format
    * 
    * @return mixed
    */
    public static function getDateRange($startDate, $endDate, $format) : mixed
    {
        try {
            $dates = array();

            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            // Loop through each day and add to the array
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->format($format);
            }

            return $dates;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Convert time stamp into date
    * 
    * @param $timestamp
    * @param $format
    * 
    * @return string
    */
    public static function convertTimeStampIntoDate($timestamp, $format) : string
    {
        try {
            return date($format, $timestamp);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Convert local time to UTC
    * 
    * @param $currentTimeZone
    * @param $date
    * 
    * @return string
    */
    public static function convertLocalToUTC($currentTimeZone, $date) : string
    {
        try {
            $localDateTime = new DateTime($date, new DateTimeZone($currentTimeZone));
            $localDateTime->setTimeZone(new DateTimeZone(Constant::UTC)); // Convert to UTC

            return $localDateTime->format(Constant::DEFAULT_DATE_FORMAT);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Convert UTC to local
    * 
    * @param $currentTimeZone
    * @param $date
    * 
    * @return string
    */
    public static function convertUTCtoLocal($currentTimeZone, $date) : string
    {
        try {
            return Carbon::createFromFormat(Constant::DEFAULT_DATE_FORMAT, $date, Constant::UTC)->setTimezone($currentTimeZone);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Time percentage calculation
    * 
    * @param $totalTime
    * @param $usedTime
    * 
    * @return int
    */
    public static function timePercentageCal($totalTime, $usedTime) : int
    {
        try {
            if ($usedTime == Constant::DEFAULT_TIMESTAMP) {
                return Constant::ZERO;
            }
            $str_time1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $totalTime);
            sscanf($str_time1, "%d:%d:%d", $hours, $minutes, $seconds);
            $totalTime = $hours * Constant::SECONDS_PER_HOUR + $minutes * Constant::SECONDS_PER_MINUTE + $seconds;

            $str_time1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $usedTime);
            sscanf($str_time1, "%d:%d:%d", $hours, $minutes, $seconds);
            $usedTime = $hours * Constant::SECONDS_PER_HOUR + $minutes * Constant::SECONDS_PER_MINUTE + $seconds;

            return (int)round(($usedTime * Constant::HUNDRED) / $totalTime);

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::ZERO;
    }

    /**
    * Divide time
    * 
    * @param $time
    * @param $count
    * 
    * @return string
    */
    public static function divideTime($time, $count) : string
    {
        try {
            if ($time == Constant::DEFAULT_TIMESTAMP) {
                return Constant::DEFAULT_TIMESTAMP;
            }

            $str_time1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
            sscanf($str_time1, "%d:%d:%d", $hours, $minutes, $seconds);
            $totalTime = $hours * Constant::SECONDS_PER_HOUR + $minutes * Constant::SECONDS_PER_MINUTE + $seconds;
            $diff = $totalTime/$count;
            $time = (int) round($diff);

            return sprintf('%02d:%02d:%02d', ($time / Constant::SECONDS_PER_HOUR), ($time / Constant::SECONDS_PER_MINUTE % Constant::SECONDS_PER_MINUTE), $time % Constant::SECONDS_PER_MINUTE);
        }catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::DEFAULT_TIMESTAMP;
    }

    /**
    * Converts time to seconds
    * 
    * @param $time
    * 
    * @return mixied
    */
    public static function timeToSec($time) : mixed
    {
        try {
            if ($time == Constant::DEFAULT_TIMESTAMP) {
                return Constant::ZERO;
            }
            $str_time1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
            sscanf($str_time1, "%d:%d:%d", $hours, $minutes, $seconds);

            return $hours * Constant::SECONDS_PER_HOUR + $minutes * Constant::SECONDS_PER_MINUTE + $seconds;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::ZERO;
    }

    /**
    * Converts time to minute
    * 
    * @param $time
    * 
    * @return int
    */
    public static function timeToMin($time) : int
    {
        try {
            if ($time == Constant::DEFAULT_TIMESTAMP) {
                return Constant::ZERO;
            }
                
            $str_time1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
            sscanf($str_time1, "%d:%d:%d", $hours, $minutes, $seconds);
            $seconds = $hours * Constant::SECONDS_PER_HOUR + $minutes * Constant::SECONDS_PER_MINUTE + $seconds;

            return (int)($seconds/Constant::SECONDS_PER_MINUTE);
        }  catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::ZERO;
    }

    /**
    * Get hours between two dates
    * 
    * @param $startDate
    * @param $endDate
    * 
    * @return mixed
    */
    public static function checkHoursBetweenTwoDates($startDate, $endDate) : mixed
    {
        try {
            $timestamp1 = strtotime($startDate);
            $timestamp2 = strtotime($endDate);

            if ($timestamp1 > $timestamp2) {
                return Constant::ZERO;
            }

            return abs($timestamp2 - $timestamp1) / (Constant::SECONDS_PER_MINUTE * Constant::SECONDS_PER_MINUTE);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::ZERO;
    }

    /**
    * Converts timestamp to min
    * 
    * @param $time
    * 
    * @return mixed
    */
    public static function timestampToMin($time) : mixed
    {
        try {
            $minutes = Constant::ZERO;

            if ($time) {
                $timeArray = explode(Constant::COLON, $time);

                if (isset($timeArray[Constant::ZERO])) { // Hours to minutes
                    $minutes += $timeArray[Constant::ZERO] * Constant::SECONDS_PER_MINUTE;
                }

                if (isset($timeArray[Constant::ONE])) {
                    $minutes += $timeArray[Constant::ONE];
                }
            }

            return $minutes;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Calculate Age (Date Format should be 'd-m-y')
    * 
    * @param $dateOfBirth
    *
    * @return int
    */
    public static function calculateAge($dateOfBirth) : int
    {
        $age = Constant::EMPTY_STRING;

        try {
            $now = new DateTime();
            $dateOfBirth = new DateTime($dateOfBirth);
            $age = $now->diff($dateOfBirth)->y;

            return $age;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* ============================================= Location Helpers ========================================== */

    /**
    * Get user location
    * 
    * @return array
    */
    public static function getUserLocation() : array
    {
        $location = Constant::ARRAY_DECLARATION;

        try {
            $ip = request()->ip();
            $response = Http::get('https://ipapi.co/' . $ip . '/json/');

            if ($response->ok()) {
                $location = $response->json();
            }

            return $location;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Latitute and logitute based on zip code
    * 
    * @param $zipCode
    * 
    * @return mixed
    */
    public static function zipCodeBaseGetLatLong($zipCode) : mixed
    {
        $response = Constant::ARRAY_DECLARATION;

        try {
            if ($zipCode != Constant::NULL) {
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $zipCode . "&sensor=false&key=" . env('GOOGLE_API_KEY');
                $details = file_get_contents($url);
                $response = json_decode($details, Constant::STATUS_TRUE);
            }

            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return $response;
        }
    }

    /**
    * Calculate Distance
    * 
    * @param $lat1
    * @param $lon1
    * @param $lat2
    * @param $lon2
    * @param $unit
    * 
    * @return float
    */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit) : float
    {
        try {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * Constant::DISTANCE_BETWEEN_LAT_LONG;
            $unit = strtoupper($unit);
        
            if ($unit == "K") { //Kilometers
                return ($miles * Constant::MILE_IN_KM);
            } else if ($unit == "N") { //Nautical Miles
                return ($miles * 0.8684);
            } else {
                return $miles; //Miles
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* ============================================== String Helpers ========================================== */

    /**
    * Prints a character
    * 
    * @param $string
    *
    * @return string
    */
    public static function printChar($string) : string
    {
        try {
            return ucwords($string[Constant::ZERO]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Converts a string to title case, which capitalizes the first letter of each word
    * 
    * @param $string
    * 
    * @return string
    */
    public static function toTitleCase($string) : string
    {
        try {
            return ucwords(strtolower($string));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Checks if the specified string starts with the given prefix
    * 
    * @param $string
    * @param $prefix
    * 
    * @return bool
    */
    public static function startsWith($string, $prefix) : bool
    {
        try {
            return strpos($string, $prefix) === Constant::ZERO;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Checks if the specified string ends with the given suffix
    * 
    * @param $string
    * @param $suffix
    * 
    * @return bool
    */
    public static function endsWith($string, $suffix) : bool
    {
        try {
            return strrpos($string, $suffix) === strlen($string) - strlen($suffix);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Explode data is used to split a string into an array based on a delimiter
    * 
    * @param $delimiter
    * @param $string
    * 
    * @return array
    */
    public static function explodeData($delimiter, $string) : array
    {
        try {
            return explode($delimiter, $string);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Implode data is used to join the elements of an array into a string, using a specified delimiter
    * 
    * @param $delimiter
    * @param $array
    * 
    * @return string
    */
    public static function implodeData($delimiter, $array) : string
    {
        try {
            return implode($delimiter, $array);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * To search a string for a specific pattern
    *
    * @param $pattern
    * @param $string
    * 
    * @return bool
    */
    public static function pregMatch($pattern, $string) : bool
    {
        try {
            return preg_match(Constant::SLASH . $pattern . Constant::SLASH, $string);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * To replace a pattern in a string
    * 
    * @param $replaceWord
    * @param $replaceWith
    * @param $string
    * 
    * @return string
    */
    public static function pregReplace($replaceWord, $replaceWith, $string) : string
    {
        try {
            return preg_replace(Constant::SLASH . $replaceWord . Constant::SLASH, $replaceWith, $string);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Removes space between words
    * 
    * @param $string
    * 
    * @return string
    */
    public static function pregRemoveSpace($string) : string
    {
        try {
            return preg_replace(Constant::SPACE_REGEX, Constant::EMPTY_STRING, $string);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Truncates text from given text and put the suffix in the text
    * 
    * @param  $text
    * @param int $length
    * @param string $suffix
    * 
    * @return string
    */
    public static function truncateText($text, $length = Constant::TEN, $suffix = Constant::BLANK_SPACE) : string
    {
        try {
            if (strlen($text) <= $length) {
                return $text;
            }
            $truncatedText = substr($text, Constant::ZERO, $length - strlen($suffix)) . $suffix;
                
            return $truncatedText;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get a string between specific characters
    * 
    * @param $string
    * @param string $start
    * @param string $end
    *
    * @return string
    */
    public static function getBetweenString($string, $start = Constant::EMPTY_STRING, $end = Constant::EMPTY_STRING) : string
    {
        try {
            if (strpos($string, $start)) { // required if $start not exist in $string
                $startCharCount = strpos($string, $start) + strlen($start);
                $firstSubStr = substr($string, $startCharCount, strlen($string));
                $endCharCount = strpos($firstSubStr, $end);
                    
                if ($endCharCount == Constant::ZERO) {
                    $endCharCount = strlen($firstSubStr);
                }
        
                return substr($firstSubStr, Constant::ZERO, $endCharCount);
            } else {
                return Constant::EMPTY_STRING;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Format phone number
    * 
    * @param $phoneNumber
    *
    * @return mixed
    */
    public static function formatPhoneNumber($phoneNumber) : mixed
    {
        try {
            $phoneNumber = preg_replace(Constant::NUMBER_REGEX, Constant::EMPTY_STRING, $phoneNumber);
            $phoneNumber = preg_replace('/^1?(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $phoneNumber);
                
            return $phoneNumber;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get error response 
    * 
    * @param string $message
    * @param int $statusCode
    * 
    * @return mixed
    */
    public static function errorResponse($message, $statusCode = Constant::CODE_400) : mixed
    {
        try {
            return response()->json(['error' => $message], $statusCode);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Status function can be used for active/inactive
    * 
    * @param $value1
    * @param $value2
    * 
    * @return array
    */
    public static function status($value1, $value2) : array
    {
        try {
            $status = [
                Constant::ZERO => $value1,
                Constant::ONE => $value2
            ];

            return $status;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Checks if a string is a valid URL
    * 
    * @param $url
    * 
    * @return bool
    */
    public static function isUrl($url) : bool
    {
        try {
            return filter_var($url, FILTER_VALIDATE_URL) !== Constant::STATUS_FALSE;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

/* =========================================== Image / File Helpers ========================================= */

    /**
    * Upload Image
    * 
    * @param $request
    * @param string $inputName
    * @param string $uploadPath
    * @param string $oldFileName
    *
    * @return array
    */
    public static function uploadImage($request, string $inputName, string $uploadPath, $oldFileName = Constant::EMPTY_STRING) : array
    {
        $imageData = Constant::ARRAY_DECLARATION;

        try {
            $image = $request->file($inputName);
            $fileName = time() . Constant::DOT . $image->getClientOriginalExtension();
            $destinationPath = $uploadPath;

            if (!empty($oldFileName)) {
                deleteFile($destinationPath, $oldFileName);
            }
            $resizeImage = Image::make($image->getPathname());
                
            //Resize & stores in small folder
            $resizeImage->resize(Constant::SMALL_WIDTH, Constant::SMALL_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            Storage::disk(Constant::DISK_PUBLIC)->put($destinationPath . Constant::FOLDER_SMALL_IMAGE . $fileName, $resizeImage);

            //Resize & stores in medium folder
            $resizeImage->resize(Constant::MEDIUM_WIDTH, Constant::MEDIUM_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            Storage::disk(Constant::DISK_PUBLIC)->put($destinationPath . Constant::FOLDER_MEDIUM_IMAGE . $fileName, $resizeImage);

            //Stores as it is
            Storage::disk(Constant::DISK_PUBLIC)->put($destinationPath . Constant::SLASH . $fileName, $image->stream());

            $imageData = [
                'image_name' => $fileName,
                'uploaded_path' => $destinationPath,
            ];
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $imageData;
    }

    /**
    * Upload multiple images
    * 
    * @param $request
    * @param string $inputName
    * @param string $uploadPath
    * @param string $oldFileName
    *
    * @return array
    */
    public static function uploadMultipleImage($request, string $inputName, string $uploadPath, $oldFileName = Constant::EMPTY_STRING) : array
    {
        $fileDataArr = Constant::ARRAY_DECLARATION;

        try {
            foreach ($request->file($inputName) as $image) {
                $fileName = rand(1, 1000) . time() . Constant::JPEG_EXTENSION;
                $destinationPath = $uploadPath;
                    
                if (!empty($oldFileName)) {
                    deleteFile($destinationPath, $oldFileName);
                }
                $resizeImage = Image::make($image->getPathname());
            
                //Resize & stores in small folder
                $resizeImage->resize(Constant::SMALL_WIDTH, Constant::SMALL_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();
                Storage::put($destinationPath . Constant::FOLDER_SMALL_IMAGE . $fileName, $resizeImage);
            
                //Resize & stores in medium folder
                $resizeImage->resize(Constant::MEDIUM_WIDTH, Constant::MEDIUM_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();
                Storage::put($destinationPath . Constant::FOLDER_MEDIUM_IMAGE . $fileName, $resizeImage);
            
                //Stores as it is
                Storage::put($destinationPath . Constant::SLASH . $fileName, $resizeImage->stream());

                $fileDataArr[] = [
                    'image_name' => $fileName,
                    'uploaded_path' => $destinationPath,
                ];                
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $fileDataArr;
    }

    /**
    * Upload file to local storage
    *
    * @param array $request
    * 
    * @return string
    */
    public static function uploadFileToLocalTemp($request) : string
    {
        try {
            $uploadFile = $request['upload_file'];
            $fileName = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME) . Constant::UNDERSCORE . time() . Constant::DOT . $uploadFile->getClientOriginalExtension();
            $localDisk = Storage::disk(Constant::DISK_LOCAL);
            $filePath = Constant::FOLDER_TEMP . $fileName;
            $localDisk->put($filePath, file_get_contents($uploadFile), Constant::DISK_PUBLIC);

            return $filePath;
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Copy file to another path
    *
    * @param $from
    * @param $to
    * 
    * @return void
    */
    public static function copyFileToAnotherPath($from, $to) : void
    {
        try {
            Storage::disk(Constant::DISK_S3)->copy($from, $to);
            
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Deletes file from given location
    * 
    * @param string $destinationPath
    * @param string $oldFileName
    *
    * @return bool
    */
    public static function deleteFile(string $destinationPath, $oldFileName = Constant::EMPTY_STRING) : bool
    {
        try {
            Storage::delete($destinationPath . $oldFileName);
            Storage::delete($destinationPath . Constant::FOLDER_SMALL_IMAGE . $oldFileName);
            Storage::delete($destinationPath . Constant::FOLDER_MEDIUM_IMAGE . $oldFileName);

            return Constant::STATUS_TRUE;
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Delete file by path
    *
    * @param $path
    * 
    * @return void
    */
    public static function deleteFileByPath($path) : void
    {
        try {
            Storage::disk(Constant::DISK_S3)->delete($path);
            
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
    * Converts image into Base64
    * 
    * @param $imagePath
    * 
    * @return string
    */
    public static function imageToBase64($imagePath) : string
    {
        try {
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageData = file_get_contents($imagePath);
            $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);

            return $base64Image;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Compress Image 
    * 
    * @param $sourcePath
    * @param $destinationPath
    * @param $quality
    * 
    * @return mixed
    */
    public static function compressImage($sourcePath, $destinationPath, $quality) : mixed
    {
        try {
            $info = getimagesize($sourcePath);

            if ($info['mime'] == Constant::MIME_JPEG) {
                $image = imagecreatefromjpeg($sourcePath);
            } elseif ($info['mime'] == Constant::MIME_PNG) {
                $image = imagecreatefrompng($sourcePath);
            } else {
                return Constant::STATUS_FALSE;
            }

            // save the compressed image to the specified destination path
            if (imagejpeg($image, $destinationPath, $quality)) {
                return Constant::STATUS_TRUE;
            } else {
                return Constant::STATUS_FALSE;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Resize Image
    * 
    * @param $sourcePath
    * @param $destinationPath
    * @param $width
    * @param $height
    * 
    * @return bool
    */
    public static function resizeImage($sourcePath, $destinationPath, $width, $height) : bool
    {
        try {
            $info = getimagesize($sourcePath);

            if ($info['mime'] == Constant::MIME_JPEG) {
                $image = imagecreatefromjpeg($sourcePath);
            } elseif ($info['mime'] == Constant::MIME_PNG) {
                $image = imagecreatefrompng($sourcePath);
            } else {
                return Constant::STATUS_FALSE;
            }

            $resizedImage = imagecreatetruecolor($width, $height);
            imagecopyresampled($resizedImage, $image, Constant::ZERO, Constant::ZERO, Constant::ZERO, Constant::ZERO, $width, $height, $info[Constant::ZERO], $info[Constant::ONE]);

            if (imagejpeg($resizedImage, $destinationPath)) {
                return Constant::STATUS_TRUE;
            } else {
                return Constant::STATUS_FALSE;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Crop Image
    * 
    * @param  $sourcePath // the path to the original image file.
    * @param  $destinationPath // the path where the cropped image will be saved.
    * @param  $width
    * @param  $height
    * @param  $x //the x-coordinate of the top-left corner of the crop area.
    * @param  $y // the y-coordinate of the top-left corner of the crop area.
    * 
    * @return mixed
    */
    public static function cropImage($sourcePath, $destinationPath, $width, $height, $x, $y) : mixed
    {
        try {
            $info = getimagesize($sourcePath);

            if ($info['mime'] == Constant::MIME_JPEG) {
                $image = imagecreatefromjpeg($sourcePath);
            } elseif ($info['mime'] == Constant::MIME_PNG) {
                $image = imagecreatefrompng($sourcePath);
            } else {
                return Constant::STATUS_FALSE;
            }

            // create a new image with the specified width and height
            $croppedImage = imagecreatetruecolor($width, $height);

            // crop the original image to the specified width, height, and coordinates
            imagecopy($croppedImage, $image, Constant::ZERO, Constant::ZERO, $x, $y, $width, $height);

            // save the cropped image to the specified destination path
            if (imagejpeg($croppedImage, $destinationPath)) {
                return Constant::STATUS_TRUE;
            } else {
                return Constant::STATUS_FALSE;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Generates a unique file name with the given file extension by appending a unique ID to the current timestamp
    * 
    * @param $extension
    * 
    * @return string
    */
    public static function generateUniqueFileName($extension) : string
    {
        try {
            return uniqid(Constant::EMPTY_STRING, Constant::STATUS_TRUE) . Constant::DOT . $extension;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Get File
    * 
    * @param string $fileName
    * @param string $basePath
    *
    * @return string
    */
    public static function getFile(string $fileName, $basePath = Constant::EMPTY_STRING) : string
    {
        try {
            $destinationPath = $basePath;
            $filePath = asset(Constant::FOLDER_STORAGE . $destinationPath . Constant::SLASH . $fileName);

            if (Storage::disk(Constant::DISK_PUBLIC)->exists($destinationPath . Constant::SLASH . $fileName)) {
                return $filePath;
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return Constant::EMPTY_STRING;
    }

    /**
    * Returns the extension of the specified file
    * 
    * @param $fileName
    * 
    * @return string
    */
    public static function getFileExtension($fileName) : string
    {
        try {
            return pathinfo($fileName, PATHINFO_EXTENSION);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Generates a URL for an uploaded file
    * 
    * @param $path
    * 
    * @return string
    */
    public static function getUploadedFileUrl($path) : string
    {
        try {
            return Storage::url($path);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Prints in readable format
    *
    * @param $file
    * 
    * @return mixed
    */
    public static function readXMLFile($file) : mixed
    {
        try {
            $xml = new DOMDocument();
            $xml->preserveWhiteSpace = Constant::STATUS_FALSE;
            $xml->load($file);
            $xml->formatOutput = Constant::STATUS_TRUE;

            return  $xml->saveXML();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Create Folder
    * 
    * @param string $destinationPath
    *
    * @return bool
    */
    public static function createFolder(string $destinationPath) : bool
    {
        try {
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, Constant::FOLDER_PERMISSION, Constant::STATUS_TRUE);

                if (!file_exists($destinationPath . Constant::FOLDER_SMALL)) {
                    mkdir($destinationPath . Constant::FOLDER_SMALL, Constant::FOLDER_PERMISSION, Constant::STATUS_TRUE);
                }

                if (!file_exists($destinationPath . Constant::FOLDER_MEDIUM)) {
                    mkdir($destinationPath . Constant::FOLDER_MEDIUM, Constant::FOLDER_PERMISSION, Constant::STATUS_TRUE);
                }
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return Constant::STATUS_TRUE;
    }

    /**
    * Delete Folder 
    * 
    * @param string $destinationPath
    * @param $folderName
    *
    * @return bool
    */
    public static function deleteFolder(string $destinationPath, $folderName) : bool
    {
        try{
            Storage::disk(Constant::DISK_PUBLIC)->deleteDirectory($destinationPath . Constant::SLASH . $folderName);
            
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return Constant::STATUS_TRUE;
    }

/* ====================================== Tax / Discount Calculation Helpers ================================ */

    /**
    * Calculate vat on price
    * 
    * @param $priceExcludingVat
    * @param $vat
    * 
    * @return mixed
    */
    public static function calculateVatOnPrice($priceExcludingVat, $vat = Constant::FIVE) : float
    {
        try {
            //Calculate how much VAT needs to be paid.
            $vatToPay = ($priceExcludingVat / Constant::HUNDRED) * $vat;

            //The total price, including VAT.
            $totalPrice = $priceExcludingVat + $vatToPay;

            //Print out the final price, with VAT added.
            //Format it to two decimal places with number_format.
            return number_format((float)$totalPrice, Constant::TWO, Constant::DOT, Constant::EMPTY_STRING);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::DEFAULT_FLOAT;
    }
    
    /**
    * Discount on price
    * 
    * @param $price
    * @param $discount
    * 
    * @return float
    */
    public static function discountOnPrice($price, $discount) : float
    {
        try {
            $vat = ((float)$price / Constant::HUNDRED) * $discount;
                
            return number_format((float)$vat, Constant::TWO, Constant::DOT, Constant::EMPTY_STRING);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return Constant::DEFAULT_FLOAT;
    }

/* ======================================== Value / Type Conversion Helpers ================================= */

    /**
    * Convert value in integer
    * 
    * @param $value
    * 
    * @return int
    */
    public static function convertValueInteger($value) : int
    {
        $finalValue = $value;

        try {
            if ($value != Constant::DEFAULT_FLOAT) {
                $finalValue = (int) $value;
            } else {
                $finalValue = Constant::ZERO;
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }

        return $finalValue;
    }

    /**
    * Converts float value to round value
    * 
    * @param $value
    * @param $precision
    *
    * @return float
    */
    public static function convertToRound(float $value, int $precision = Constant::ONE): float
    {
        try {
            return round(abs($value), $precision);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Converts foot/inches to centimeter.
    *
    * @param string $feet
    * @param string $inches
    *
    * @return int
    */
    public static function convertToCM($feet = Constant::EMPTY_STRING, $inches = Constant::EMPTY_STRING) : int
    {
        $cm = Constant::ZERO;

        try {
            $feet = str_replace(Constant::COMMA, Constant::DOT, $feet);
            $inches = str_replace(Constant::COMMA, Constant::DOT, $inches);
            $inches = ((int)$feet * Constant::TWELVE) + (int)$inches;
            $cm = (int)round($inches * Constant::INCH_IN_CM);
        
            return $cm;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Converts centimeter to inches.
    *
    * @param $cm
    *
    * @return array
    */
    public static function convertToInches($cm = Constant::EMPTY_STRING) : array
    {
        $result = Constant::ARRAY_DECLARATION;

        try {
            if ($cm) {
                $cm = str_replace(Constant::COMMA, Constant::DOT, $cm);

                if (is_numeric($cm)) {
                    $inches = $cm / Constant::INCH_IN_CM;

                    $result = [
                        'ft' => intval($inches / Constant::TWELVE),
                        'in' => $inches % Constant::TWELVE,
                    ];
                }
            }

            return $result;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
    * Converts pounds to kilogram.
    *
    * @param int $pounds
    *
    * @return float|int
    */
    public static function convertToKG($pounds = Constant::ZERO) : float | int
    {
        $kg = Constant::ZERO;
        $pounds = str_replace(Constant::COMMA, Constant::DOT, $pounds);

        try {
            if ($pounds) {
                $lbsInKg = Constant::LBS_IN_KG;
                $kg = $pounds * $lbsInKg;
            }

            return $kg;
        } catch (Exception $ex) {
            Log::error($ex);

            return $kg;
        }
    }

    /**
    * Converts kilogram to pounds.
    *
    * @param string $kg
    *
    * @return float|int
    */
    public static function convertToPounds($kg = Constant::EMPTY_STRING) : float | int
    {
        $lbs = Constant::ZERO;
        $kg = str_replace(Constant::COMMA, Constant::DOT, $kg);

        try {
            if ($kg) {
                $lbsInKg = Constant::LBS_IN_KG;
                $lbs = $kg / $lbsInKg;
            }

            return $lbs;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return $lbs;
        }
    }
}