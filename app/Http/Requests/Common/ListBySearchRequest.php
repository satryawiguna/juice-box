<?php

namespace App\Http\Requests\Common;

class ListBySearchRequest extends ListRequest
{
    public function rules()
    {
        return array_merge([
            'search' => ['string', 'nullable'],
        ], parent::rules());
    }

    public function prepareForValidation()
    {
        $this->merge($this->withSearch());
    }

    protected function withSearch()
    {
        return array_merge(
            $this->withOrderSort(),
            ['search' => $this->get('search', null)]
        );
    }
}
