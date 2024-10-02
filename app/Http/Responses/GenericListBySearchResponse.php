<?php

namespace App\Http\Responses;

use Illuminate\Support\Collection;

class GenericListBySearchResponse extends BaseResponse
{
    public Collection $dtoListBySearch;

    public int $totalCount;

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getDtoListBySearch(): Collection
    {
        return $this->dtoListBySearch ?? new Collection();
    }
}
