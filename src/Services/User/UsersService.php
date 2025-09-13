<?php

namespace Maksb\Admin\Services\User;

use App\Dto\Auth\NewUserDto;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    public function createNewUser(NewUserDto $newUserDto): User
    {
        $user = User::query()->create(
            [
                'name' => $newUserDto->getName(),
                'email' => $newUserDto->getEmail(),
                'password' => Hash::make($newUserDto->getPassword()),
            ]
        );

        event(new Registered($user));

        return $user;
    }
}
