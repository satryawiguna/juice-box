<?php

namespace App\Http\Responses;

class GenericResponse extends BaseResponse
{
    public mixed $result;

    public function getResult(): mixed
    {
        return $this->result;
    }

    public function setResult($result): void
    {
        $this->result = $result;
    }
}
