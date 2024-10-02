<?php

use App\Models\Reservation;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use WhichBrowser\Parser;

if (!function_exists('parseCustomTags')) {
    function parseCustomTags($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        return $content;
    }
}

if (!function_exists('extractAirportCodesToQueryString')) {
    function extractAirportCodesToQueryString($codes)
    {
        if (strpos($codes, ',') !== false) {
            $codeArray = explode(',', $codes);
        }
        else {
            $codeArray = [$codes];
        }

        $formattedCodes = [];

        foreach ($codeArray as $code) {
            $formattedCodes[] = 'codes=' . $code;
        }

        $output = '?' . implode('&', $formattedCodes);

        return $output;
    }
}

if (!function_exists('extractAirportCountryCodesToQueryString')) {
    function extractAirportCountryCodesToQueryString($codes)
    {
        if (strpos($codes, ',') !== false) {
            $codeArray = explode(',', $codes);
        }
        else {
            $codeArray = [$codes];
        }

        $formattedCodes = [];

        foreach ($codeArray as $code) {
            $formattedCodes[] = 'countryCode=' . $code;
        }

        $output = '?' . implode('&', $formattedCodes);

        return $output;
    }
}

if (!function_exists('convertKeysToCamelCase')) {
    function convertKeysToCamelCase($array)
    {
        $result = [];

        foreach ($array as $key => $value) {
            $camelCaseKey = str_replace('_', '', ucwords($key, '_'));
            $result[$camelCaseKey] = is_array($value) && $key !== 'properties' ? convertKeysToCamelCase($value) : $value;

            unset($camelCaseKey);
        }

        return $result;
    }
}

if (!function_exists('convertKeysToSnakeCase')) {
    function convertKeysToSnakeCase($array)
    {
        $result = [];

        foreach ($array as $key => $value) {
            $snakeCaseKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            $result[$snakeCaseKey] = is_array($value) && $key !== 'Properties' ? convertKeysToSnakeCase($value) : $value;

            unset($snakeCaseKey);
        }

        return $result;
    }
}

if (!function_exists('getLoggingContext')) {
    function getLoggingContext()
    {
        $route = Route::current();

        $userAgent = request()->header('User-Agent');
        $parser = new Parser($userAgent);

        return [
            'user_id' => optional(auth()->user())->id,
            'ip_address' => request()->ip(),
            'route_name' => $route?->getName(),
            'route_action' => $route?->getActionName(),
            'request_method' => request()->method(),
            'request_data' => request()->all(),
            'browser_name' => $parser->browser->toString(),
            'browser_version' => optional($parser->browser->version)->toString(),
        ];
    }
}

if (!function_exists('createHttpClient')) {
    function createHttpClient()
    {
        return new Client([
            'decode_content' => 'gzip',
            'dns_cache' => true,
            'http_options' => [
                'pool_size' => 5
            ]
        ]);
    }
}

if (!function_exists('convertContactType')) {
    function convertContactType(int|string $type)
    {
        switch ($type) {
            case 1:
            case 'Adult':
            default:
                return 'ADULT';
            case 2:
            case 'Child':
                return 'CHILD';
            case 3:
            case 'Infant':
                return 'INFANT';
        }
    }
}

if (!function_exists('convertGender')) {
    function convertGender(string $gender)
    {
        switch ($gender) {
            case 'Male':
                return 'MALE';
            case 'Female':
                return 'FEMALE';
            case 'Unknown':
            default:
                return null;
        }
    }
}

if (!function_exists('truncateString')) {
    function truncateString(string $text, int $length)
    {
        $maxLength = $length;
        $suffix = ' ...';

        $maxLength = $maxLength - mb_strlen($suffix) - 1;

        if (mb_strlen($text) > $maxLength) {
            $truncateText = mb_strimwidth($text, 0, $maxLength) . $suffix;
        }
        else {
            $truncateText = $text;
        }

        return $truncateText;
    }
}

if (!function_exists('cleanFileName')) {
    function cleanFileName($originalFileName)
    {
        // 1. Replace all white spaces and any kind of symbols with a dash "-"
        $cleanedName = preg_replace('/[^\w\s-]+/', '-', $originalFileName);
        $cleanedName = preg_replace('/\s+/', '-', $cleanedName);

        // 2. Convert all characters to lowercase
        $cleanedName = strtolower($cleanedName);

        // 3. Remove any trailing symbols or dashes
        $cleanedName = rtrim($cleanedName, '-');

        return $cleanedName;
    }
}

if (!function_exists('generateUniqueBookingCode')) {
    function generateUniqueBookingCode($length = 6)
    {
        do {
            $code = Str::random($length);

            $exists = Reservation::where('booking_code', $code)->exists();

            if ($exists) $length++;
        }
        while ($exists);

        return $code;
    }
}
