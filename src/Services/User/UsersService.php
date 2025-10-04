<?php

namespace Maksb\Admin\Services\User;

use Maksb\Admin\Dto\Auth\NewUserDto;
use Illuminate\Support\Facades\Hash;
use Maksb\Admin\Models\AdminUser;

class UsersService
{
    public function createNewUser(NewUserDto $newUserDto): AdminUser
    {
        return AdminUser::query()->create(
            [
                'name' => $newUserDto->getName(),
                'email' => $newUserDto->getEmail(),
                'password' => Hash::make($newUserDto->getPassword()),
            ]
        );
    }
}
