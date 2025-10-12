<?php

namespace Maksb\Admin\Console\commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maksb\Admin\Domain\Auth\PermissionsEnum;
use Maksb\Admin\Domain\Auth\UserRolesEnum;
use Maksb\Admin\Models\AdminUser;
use Maksb\Admin\Services\User\RbacService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminInstallCommand extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install admin panel package';

    public function handle(
        Filesystem $files,
        RbacService $rbacService,
    ) {
        $this->info('Installing admin panel...');

        $this->publishRbac();

        $this->call('vendor:publish', [
            '--provider' => "Maksb\\Admin\\AdminServiceProvider",
        ]);

        $this->buildFrontend($files);

        $this->call('migrate');

        $this->createAdminUser($rbacService);

        $this->info('Admin Panel installed...');
    }

    private function buildFrontend(Filesystem $files): void
    {
        $this->changeBuilderFile('vite.config.js', $files->get(__DIR__ . '/../../../vite.config.js'));
        $this->changeBuilderFile('postcss.config.js', $files->get(__DIR__ . '/../../../install-stubs/postcss.config.js'));
        $this->changeBuilderFile('tailwind.config.js', $files->get(__DIR__ . '/../../../install-stubs/tailwind.config.js'));

        $this->info('Updating package.json');

        $packageJson = $files->get(__DIR__ . '/../../../package.json');

        $packageFileJsonData = json_decode($packageJson, JSON_OBJECT_AS_ARRAY);

        $mainJsonFile = base_path('package.json');
        $mainJson = $files->get($mainJsonFile);

        $mainFileJsonData = json_decode($mainJson, JSON_OBJECT_AS_ARRAY);

        foreach ($packageFileJsonData['devDependencies'] as $lib => $version) {
            $mainFileJsonData['devDependencies'][$lib] = $version;
        }

        foreach ($packageFileJsonData['dependencies'] as $lib => $version) {
            $mainFileJsonData['dependencies'][$lib] = $version;
        }

        $files->put($mainJsonFile, json_encode($mainFileJsonData, JSON_PRETTY_PRINT));

        $this->info('package.json modified');
    }

    private function changeBuilderFile(string $fileName, string $content): void
    {
       File::put($fileName, $content);
    }

    private function createAdminUser(RbacService $rbacService): void
    {
        $adminRole = Role::query()
            ->where('guard_name', 'admin')
            ->where('name', UserRolesEnum::ROLE_ADMIN)
            ->first();

        if (!$adminRole) {
            $adminRole = $rbacService->createRole(UserRolesEnum::ROLE_ADMIN);
        }

        $permissionDashboard = Permission::query()
            ->where('guard_name', 'admin')
            ->where('name', PermissionsEnum::SHOW_DASHBOARD)
            ->first();

        if (!$permissionDashboard) {
            $permissionDashboard = $rbacService->createPermission(PermissionsEnum::SHOW_DASHBOARD);
        }

        $permissionAdmins = Permission::query()
            ->where('guard_name', 'admin')
            ->where('name', PermissionsEnum::ADMINS_INDEX)
            ->first();

        if (!$permissionAdmins) {
            $permissionAdmins = $rbacService->createPermission(PermissionsEnum::ADMINS_INDEX);
        }

        $rbacService->addPermissions($adminRole, [$permissionDashboard, $permissionAdmins]);

        $user = AdminUser::query()->where('email', 'admin@test.com')->first();

        if (!$user) {
            $user = AdminUser::create([
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
            ]);
        }

        $rbacService->assignUserToRole($user, $adminRole);
    }

    private function publishRbac(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
        ]);
    }
}
