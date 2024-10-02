<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;

class UserController extends ApiBaseController
{
    protected readonly IUserService $_userService;

    public function __construct(IUserService $userService)
    {
        $this->_userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $register = $this->_userService->register($request);

        if ($register->isError()) {
            return $this->getErrorLatestJsonResponse($register);
        }

        return $this->getSuccessLatestJsonResponse($register);
    }

    public function login(LoginRequest $request)
    {
        $login = $this->_userService->login($request);

        if ($login->isError()) {
            return $this->getErrorLatestJsonResponse($login);
        }

        return $this->getObjectJsonResponse($login, LoginResource::class);
    }

    public function logout()
    {
        $logout = $this->_userService->logout();

        if ($logout->isError()) {
            return $this->getErrorLatestJsonResponse($logout);
        }

        return $this->getSuccessLatestJsonResponse($logout);
    }

    public function show(string $id)
    {
        $user = $this->_userService->getUser($id);

        if ($user->isError()) {
            return $this->getErrorLatestJsonResponse($user);
        }

        return $this->getObjectJsonResponse($user, UserResource::class);
    }

    public function verify(Request $request)
    {
        $verify = $this->_userService->verify($request);

        if ($verify->isError()) {
            return $this->getErrorLatestJsonResponse($verify);
        }

        return $this->getSuccessLatestJsonResponse($verify);
    }
}
