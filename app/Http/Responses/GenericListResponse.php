<?php

namespace App\Http\Responses;

use Illuminate\Support\Collection;

class GenericListResponse extends BaseResponse
{
    public Collection $dtoList;

    public int $totalCount;

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getDtoList(): Collection
    {
        return $this->dtoList ?? new Collection();
    }
}
