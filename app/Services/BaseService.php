<?php

namespace App\Services;

use App\Enums\ContentType;
use App\Services\Contracts\IBaseService;
use App\Traits\JsonResponseHandler;
use Illuminate\Support\Facades\Cache;

class BaseService implements IBaseService
{
    use JsonResponseHandler;

    public function getOpsigoRequestHeader(string $type = ContentType::JSON->value,
                                           bool   $isAuthorized = false): array
    {
        $header = [
            'Accept' => 'application/json',
            'Connection' => 'keep-alive'
        ];

        if ($type === ContentType::JSON->value) {
            $header['Content-Type'] = 'application/json';
        } elseif ($type === ContentType::FORM_DATA->value) {
            $header['Content-Type'] = 'multipart/form-data';
        } elseif ($type === ContentType::X_WWW_FORM_URLENCODED->value) {
            $header['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        if ($isAuthorized) {
            $token = Cache::get('o_at');

            $header['Authorization'] = 'Bearer ' . $token;
        }

        return $header;
    }

    public function getCountryStateCityHeader(): array
    {
        $header = [
            'X-CSCAPI-KEY' => env('COUNTRY_STATE_CITY_SECRET')
        ];

        return $header;
    }
}
