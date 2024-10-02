<?php

namespace App\Http\Requests\Blog;

use Illuminate\Contracts\Validation\ValidationRule;

class PostUpdateRequest extends PostStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = array_merge(parent::rules(), [
            'status' => ['string', 'in:DRAFT,PUBLISHED,ARCHIVED']
        ]);

        return $this->setRuleAuthor($rules);
    }
}
