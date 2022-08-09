<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\IndexUsersRequest;
use App\Http\Requests\User\LoginUserRequest as LoginRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(IndexUsersRequest $request)
    {
        return $this->handleJsonResponse($this->service->getPagination($request->email, $request->name, $request->page));
    }

    public function show(User $user)
    {
        return $this->handleJsonResponse($this->service->get($user));
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        return $this->handleJsonResponse($this->service->update($user, $request->name, $request->family));
    }

    public function changePassword(User $user, ChangePasswordRequest $request)
    {
        return $this->handleJsonResponse($this->service->changePassword($user, $request->new_password));
    }

    public function login(LoginRequest $request)
    {
        return $this->handleJsonResponse($this->service->login($request->email, $request->password));
    }

    public function logout()
    {
        return $this->handleJsonResponse($this->service->logout());
    }
}
