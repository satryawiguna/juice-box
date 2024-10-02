<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Common\ListRequest;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IBaseRepository
{
    public function all(ListRequest $request): Collection;

    public function allWith(ListRequest $request, array $relation): Collection;

    public function findById(int|string $id): ?BaseModel;

    public function findWithById(int|string $id, array $relation): ?BaseModel;

    public function findOrNew(array $data): BaseModel;

    public function count(): int;

    public function create(Request $request): BaseModel;

    public function update(Request $request): ?bool;

    public function delete(int|string $id): ?bool;
}
