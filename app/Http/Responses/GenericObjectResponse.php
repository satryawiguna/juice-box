<?php

namespace App\Http\Responses;

use stdClass;

class GenericObjectResponse extends BaseResponse
{
    public mixed $dto;

    public function getDto(): mixed
    {
        return $this->dto ?? new stdClass();
    }
}
