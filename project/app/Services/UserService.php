<?php

namespace App\Services;

use App\Constants\ErrorCodes;
use App\Models\User as Entity;
use App\Http\Resources\UserResource as EntityResource;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function __construct()
    {
        $this->entityResource = EntityResource::class;
    }

    public function get($user)
    {
        return $this->handleGet(Entity::get($user->id));
    }

    public function getAuth($gaurd = 'web')
    {
        return $this->handleGet(Entity::get(auth($gaurd)->user()->id));
    }

    public function getPagination($email, $nameFamily, $page)
    {
        return $this->handleGetItems(Entity::getPagination($email, $nameFamily, $nameFamily, $page));
    }

    public function update($user, $name, $family)
    {
        $data = [
            'name' => $name,
            'family' => $family,
        ];

        return $this->handleUpdate($user->update($data));
    }

    public function changePassword($user, $password)
    {
        Entity::updatePassword($user->id, Hash::make($password));

        return $this->handleOK();
    }

    public function login($email, $password, $guard = 'web')
    {
        if (!auth($guard)->attempt(['email' => $email, 'password' => $password])) {
            return $this->handleError(['_error' => __('user.user_not_found'), '_errorCode' => ErrorCodes::USER_NOT_FOUND]);
        }

        return $this->handleOK(['user' => auth()->user()]);
    }

    public function logout($guard = null)
    {
        auth($guard)->logout();

        return $this->handleOK();
    }
}
