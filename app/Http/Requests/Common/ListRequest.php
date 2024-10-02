<?php

namespace App\Http\Requests\Common;

class ListRequest extends BaseRequest
{
    protected string $_order_by = 'created_at';

    protected string $_sort = 'ASC';

    public function rules()
    {
        return [
            'order_by' => ['string'],
            'sort' => ['string', 'regex:(ASC|DESC)'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge($this->withOrderSort());
    }

    protected function withOrderSort()
    {
        return [
            'order_by' => $this->get('order_by', $this->_order_by),
            'sort' => $this->get('sort', $this->_sort),
        ];
    }
}
