<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Blog\PostSearchAndPaginationRequest;
use App\Http\Requests\Blog\PostSearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IPostRepository extends IBaseRepository
{
    public function allSearch(PostSearchRequest $request): Collection;

    public function allSearchAndPagination(PostSearchAndPaginationRequest $request): LengthAwarePaginator;
}
