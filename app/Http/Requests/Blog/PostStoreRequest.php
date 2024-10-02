<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\Common\AuditableRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class PostStoreRequest extends AuditableRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
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
