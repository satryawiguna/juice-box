<?php

namespace App\Http\Requests\Common;

class ListBySearchAndPaginationRequest extends ListBySearchRequest
{
    protected int $_page = 1;

    protected int $_per_page = 10;

    public function rules()
    {
        return array_merge([
            'page' => ['integer', 'min:1'],
            'per_page' => ['integer', 'min:2'],
        ], parent::rules());
    }

    public function prepareForValidation()
    {
        $this->merge($this->withSearchAndPagination());
    }

    protected function withSearchAndPagination()
    {
        return array_merge(
            $this->withOrderSort(),
            $this->withSearch(),
            [
                'page' => $this->get('page', $this->_page),
                'per_page' => $this->get('per_page', $this->_per_page),
            ]);
    }
}
