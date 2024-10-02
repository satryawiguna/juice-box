<?php

namespace App\Http\Requests\Common;

use App\Enums\MessageType;
use App\Http\Responses\GenericResponse;
use App\Traits\JsonResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseRequest extends FormRequest
{
    use JsonResponseHandler;

    protected function failedValidation(Validator $validator)
    {
        $response = new GenericResponse();

        throw new HttpResponseException($this->getJsonResponse(
            $this->setGenericResponse($response,
                $validator->errors(),
                MessageType::ERROR,
                Response::HTTP_BAD_REQUEST)
        ));
    }
}
