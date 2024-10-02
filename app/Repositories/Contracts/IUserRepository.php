<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\RegisterRequest;
use App\Models\BaseModel;

interface IUserRepository extends IBaseRepository
{
    public function storeUser(RegisterRequest $request): BaseModel;
}
