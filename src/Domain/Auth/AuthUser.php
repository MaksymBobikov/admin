<?php
namespace Maksb\Admin\Domain\Auth;

interface AuthUser
{
    public function hasRole($roles, ?string $guard = null): bool;
}
