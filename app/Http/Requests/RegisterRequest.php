<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\AuditableRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class RegisterRequest extends AuditableRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', Rule::unique('users', 'username')],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'mobile_phone' => ['required', 'string']
        ];

        return $this->setRuleAuthor($rules);
    }

    public function prepareForValidation()
    {
        $this->setValueAuthor($this);
    }

    public function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    }
}
