<?php

namespace App\Services\Contracts;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\GenericObjectResponse;
use Illuminate\Http\Request;

interface IUserService
{
    public function register(RegisterRequest $request): BaseResponse;

    public function login(LoginRequest $request): GenericObjectResponse;

    public function logout(): BaseResponse;

    public function getUser(string $id): GenericObjectResponse;

    public function verify(Request $request): BaseResponse;
}
