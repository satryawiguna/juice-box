<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\Common\ListRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class PostListRequest extends ListRequest
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
            'publish_dates' => ['nullable', 'json', function ($attribute, $value, $fail) {
                $dates = json_decode($value, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $fail('The ' . $attribute . ' must be a valid JSON string.');
                    return;
                }

                if (isset($dates['start'])) {
                    if (!strtotime($dates['start'])) {
                        $fail('The start date in ' . $attribute . ' is not a valid date.');
                    }
                }

                if (isset($dates['end'])) {
                    if (!strtotime($dates['end'])) {
                        $fail('The end date in ' . $attribute . ' is not a valid date.');
                    }

                    if (isset($dates['start']) && strtotime($dates['end']) < strtotime($dates['start'])) {
                        $fail('The end date in ' . $attribute . ' must be a date after or equal to the start date.');
                    }
                }
            }],
            'status' => ['nullable', 'numeric']
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
