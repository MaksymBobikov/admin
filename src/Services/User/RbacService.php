<?php

namespace Maksb\Admin\Services\User;

use Maksb\Admin\Domain\Auth\AuthUser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RbacService
{
    public function createRole(string $name, string $guardName = 'admin'): Role
    {
        return Role::create(['guard_name' => $guardName, 'name' => $name]);
    }

    public function createPermission(string $name, string $guardName = 'admin'): Permission
    {
        return  Permission::create(['guard_name' => $guardName, 'name' => $name]);
    }

    public function addPermissions(Role $role, ...$permissions): void
    {
        $role->givePermissionTo($permissions);
    }

    public function syncPermissions(Role $role, ...$permissions): void
    {
        $role->syncPermissions($permissions);
    }

    public function removePermissions(Role $role, $permission): void
    {
        $role->revokePermissionTo($permission);
    }

    public function assignUserToRole(AuthUser $user, ...$roles): void
    {
        $user->assignRole($roles);
    }

    public function removeRole(AuthUser $user, $role): void
    {
        $user->removeRole($role);
    }
}
