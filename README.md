<h1 align="center">Laravel Utils</h1>

![Packagist License](https://img.shields.io/packagist/l/vcian/laravel-utils?style=for-the-badge)
[![Total Downloads](https://img.shields.io/packagist/dt/vcian/laravel-utils?style=for-the-badge)](https://packagist.org/packages/vcian/laravel-utils)

## Introduction

- This package provides helpful and neccessary helper functions which can be useful in your Laravel projects.

## Installation & Usage

> **Requires [PHP 8.0+](https://php.net/releases/) | [Laravel 8.0+](https://laravel.com/docs/8.x)**

Require Laravel Utils using [Composer](https://getcomposer.org):

```bash
composer require --dev vcian/laravel-utils
```
## Usage:

You can access different helper functions mentioned below.

```php
use Vcian\LaravelUtils\LaravelUtils;
```

## General Functions

1) <font color="cyan">Grab the application name</font> <br>
```LaravelUtils::appName()```
2) Get logged in user <br>
```LaravelUtils::loggedInUser()```
3) Check login status <br>
```LaravelUtils::checkAuth()```
4) Encrypt given value <br>
```LaravelUtils::encryption($string)```
5) Decrypt given value <br>
```LaravelUtils::decryption($string)```
6) Get server user agent <br>
```LaravelUtils::getUserAgent()```

## Database Functions

7) Check database connection <br>
```LaravelUtils::checkDbConnection()```
8) Print query <br>
```LaravelUtils::printQuery($string)```
9) Select query <br>
```LaravelUtils::selectQuery($table, $columns, $conditions, $orderBy, $limit)```
10) Insert record <br>
```LaravelUtils::insertQuery($table, $data)```
11) Update record <br>
```LaravelUtils::updateQuery($table, $data, $conditions)```
12) Delete record <br>
```LaravelUtils::deleteQuery($table, $conditions)```
13) Filter query with condition <br>
```LaravelUtils::filterQuery($table, $column, $operator, $value)```
14) Get records in specific order <br>
```LaravelUtils::orderResults($table, $column, $direction)```
15) Count number of records in table <br>
```LaravelUtils::countResults($table)```
16) Join query for tables <br>
```LaravelUtils::joinTables($table1, $table2, $column1, $column2)```
17) Get paginate results <br>
```LaravelUtils::getPaginatedResults($query, $perPage)```

## Laravel Custom Route Functions

18) Searches sub-directories <br>
```LaravelUtils::includeRouteFiles($folder)```
19) Get route URL <br>
```LaravelUtils::getRouteUrl($url, $urlType, $separator)```

## API Connection/Response Functions

20) Generate API token <br>
```LaravelUtils::generateApiToken()```
21) CURL request <br>
```LaravelUtils::callAPI($url, $method, $data, $headers)```
22) Get Json Response from API <br>
```LaravelUtils::jsonResponseFromAPI($data, $statusCode)```

## CSS Functions

23) Get css and js path <br>
```LaravelUtils::customAsset($path)```
24) Get active menu <br>
```LaravelUtils::activeMenu($route, $page)```
25) Generate random color <br>
```LaravelUtils::getRandomColor()```

## Array Search Function

26) Search in array <br>
```LaravelUtils::arrayPartialSearch($array, $keyword)```

## Data Conversion Functions

27) Convert object to array <br>
```LaravelUtils::objectToArray($collection)```
28) Get Json to array <br>
```LaravelUtils::jsonToArray($names)```
29) CSV to ARRAY (Convert file CSV to array) <br>
```LaravelUtils::csvToArray($filename)```
30) Array to CSV file <br>
```LaravelUtils::arrayToCsv($data, $fileName)```

## Date & Time Functions

31) Get current timestamp in the specified timezone <br>
```LaravelUtils::getCurrentTimestamp($timezone)```
32) Get current year <br>
```LaravelUtils::getCurrentYear()```
33) Get current month <br>
```LaravelUtils::getCurrentMonth()```
34) Get current date <br>
```LaravelUtils::getCurrentDate()```
35) Get sum of time <br>
```LaravelUtils::timeSumCalculation($times)```
36) Get hours difference <br>
```LaravelUtils::getHoursDifference($createdDate)```
37) Get days difference <br>
```LaravelUtils::getDaysDiff($date1, $date2)```
38) Get date range <br>
```LaravelUtils::getDateRange($startDate, $endDate, $format)```
39) Convert timestamp into date <br>
```LaravelUtils::convertTimeStampIntoDate($timestamp, $format)```
40) Convert local time to UTC <br>
```LaravelUtils::convertLocalToUTC($currentTimeZone, $date)```
41) Convert UTC to local <br>
```LaravelUtils::convertUTCtoLocal($currentTimeZone, $date)```
42) Time percentage calculation <br>
```LaravelUtils::timePercentageCal($totalTime, $usedTime)```
43) Divide time <br>
```LaravelUtils::divideTime($time, $count)```
44) Convert time to seconds <br>
```LaravelUtils::timeToSec($time)```
45) Convert time to minute <br>
```LaravelUtils::timeToMin($time)```
46) Get hours between two dates <br>
```LaravelUtils::checkHoursBetweenTwoDates($startDate, $endDate)```
47) Convert timestamp to min <br>
```LaravelUtils::timestampToMin($time)```
48) Calculate Age (Date Format should be 'd-m-y') <br>
```LaravelUtils::calculateAge($dateOfBirth)```

## Location Functions

49) Get user location <br>
```LaravelUtils::getUserLocation()```
50) Get latitute and logitute based on zip code <br>
```LaravelUtils::zipCodeBaseGetLatLong($zipCode)```
51) Calculate Distance <br>
```LaravelUtils::calculateDistance($lat1, $lon1, $lat2, $lon2, $unit)```

## String Functions

52) Print a character <br>
```LaravelUtils::printChar($string)```
53) Convert a string to title case <br>
```LaravelUtils::toTitleCase($string)```
54) Check if the specified string starts with the given prefix <br>
```LaravelUtils::startsWith($string, $prefix)```
55) Check if the specified string ends with the given suffix <br>
```LaravelUtils::endsWith($string, $suffix)```
56) Explode a string into an array <br>
```LaravelUtils::explodeData($delimiter, $string)```
57) Implode a array into a string <br>
```LaravelUtils::implodeData($delimiter, $array)```
58) Search a string for a specific pattern <br>
```LaravelUtils::pregMatch($pattern, $string)```
59) Replace a pattern in a string <br>
```LaravelUtils::pregReplace($replaceWord, $replaceWith, $string)```
60) Remove space between words <br>
```LaravelUtils::pregRemoveSpace($string)```
61) Truncate text from given text and put the suffix in the text <br>
```LaravelUtils::truncateText($text, $length, $suffix)```
62) Get a string between specific characters <br>
```LaravelUtils::getBetweenString($string, $start, $end)```
63) Format phone number <br>
```LaravelUtils::formatPhoneNumber($phoneNumber)```
64) Get error response <br>
```LaravelUtils::errorResponse($message, $statusCode)```
65) Link Formating <br>
```LaravelUtils::linkFormatting($link)```

## Image/File Functions

66) Upload Image <br>
```LaravelUtils::uploadImage($request, $inputName, $uploadPath, $oldFileName)```
67) Upload multiple images <br>
```LaravelUtils::uploadMultipleImage($request, $inputName, $uploadPath, $oldFileName)```
68) Upload file to local storage <br>
```LaravelUtils::uploadFileToLocalTemp($request)```
69) Copy file to another path <br>
```LaravelUtils::copyFileToAnotherPath($from, $to)```
70) Delete file from given location <br>
```LaravelUtils::deleteFile($destinationPath, $oldFileName)```
71) Delete file by path <br>
```LaravelUtils::deleteFileByPath($path)```
72) Convert image into Base64 <br>
```LaravelUtils::imageToBase64($imagePath)```
73) Compress Image <br>
```LaravelUtils::compressImage($sourcePath, $destinationPath, $quality)```
74) Resize Image <br>
```LaravelUtils::resizeImage($sourcePath, $destinationPath, $width, $height)```
75) Crop Image <br>
```LaravelUtils::cropImage($sourcePath, $destinationPath, $width, $height, $x, $y)```
76) Generate a unique file name <br>
```LaravelUtils::generateUniqueFileName($extension)```
77) Get File <br>
```LaravelUtils::getFile($fileName, $basePath)```
78) Get the extension of the specified file <br>
```LaravelUtils::getFileExtension($fileName)```
79) Generate URL for an uploaded file <br>
```LaravelUtils::getUploadedFileUrl($path)```
80) Print XML in readable format <br>
```LaravelUtils::readXMLFile($file)```
81) Create Folder <br>
```LaravelUtils::createFolder($destinationPath)```
82) Delete Folder <br>
```LaravelUtils::deleteFolder($destinationPath, $folderName)```

## Value/Type Conversion Functions

83) Convert value in integer <br>
```LaravelUtils::convertValueInteger($value)```
84) Convert float value to round value <br>
```LaravelUtils::convertToRound($value, $precision)```
85) Convert foot/inches to centimeter <br>
```LaravelUtils::convertToCM($feet, $inches)```
86) Convert centimeter to inches <br>
```LaravelUtils::convertToInches($cm)```
87) Convert pounds to kilogram <br>
```LaravelUtils::convertToKG($pounds)```
88) Convert kilogram to pounds <br>
```LaravelUtils::convertToPounds($kg)```

## VAT/Discount Calculation Functions

89) Calculate vat on price <br>
```LaravelUtils::calculateVatOnPrice($priceExcludingVat, $vat)```
90) Discount on price <br>
```LaravelUtils::discountOnPrice($price, $discount)```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

       We believe in 
            👇
          ACT NOW
      PERFECT IT LATER
    CORRECT IT ON THE WAY.

## Security

If you discover any security-related issues, please email ruchit.patel@viitor.cloud instead of using the issue tracker.

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.