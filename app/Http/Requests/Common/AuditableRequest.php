<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuditableRequest extends BaseRequest
{
    protected function setRuleAuthor(array $rules)
    {
        return array_merge($rules, [
            'request_by' => ['string'],
        ]);
    }

    protected function setValueAuthor(FormRequest $request): void
    {
        $request->merge(['request_by' => (Auth::user()) ? Auth::user()->username : 'system']);
    }
}
