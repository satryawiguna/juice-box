<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class PostSearchAndPaginationRequest extends ListBySearchAndPaginationRequest
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
        return array_merge([
            'publish_dates' => ['nullable', 'array'],
            'publish_dates.start' => ['required_with:publish_dates.end', 'date'],
            'publish_dates.end' => ['required_with:publish_dates.start', 'date', 'after_or_equal:publish_dates.start'],
            'status' => ['nullable', 'string'],
        ], parent::rules());
    }

    public function prepareForValidation()
    {
        $this->merge(array_merge(
            $this->withOrderSort(),
            [
                'publish_dates' => $this->get('publish_dates', null),
                'status' => $this->get('status', null),
            ]
        ));
    }
}
