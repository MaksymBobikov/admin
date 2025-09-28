<?php

namespace Maksb\Admin\Console\commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class AdminInstallCommand extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install admin panel package';

    public function handle(Filesystem $files)
    {
        $this->info('Installing admin panel...');

        $this->call('vendor:publish', [
            '--provider' => "Maksb\\Admin\\AdminServiceProvider",
        ]);

        $this->buildFrontend($files);

        $this->call('migrate');

        $this->info('Admin Panel installed...');
    }

    private function buildFrontend(Filesystem $files): void
    {
        if ($this->changeBuilderFile('vite.config.js', '|resources/admin/js|', $files->get(__DIR__ . '/../../../install-stubs/vite.config.js'))) {
            $this->info('Vite config updated');
        }

        $this->info('Updating package.json');

        $packageJsonFile = base_path('package.json');
        $packageJson = $files->get($packageJsonFile);

        $packageFileJsonData = json_decode($packageJson, JSON_OBJECT_AS_ARRAY);

        $packageFileJsonData['devDependencies']['autoprefixer'] = '^10.4.20';
        $packageFileJsonData['devDependencies']['axios'] = '^1.7.4';
        $packageFileJsonData['devDependencies']['concurrently'] = '^9.0.1';
        $packageFileJsonData['devDependencies']['laravel-vite-plugin'] = '^1.2.0';
        $packageFileJsonData['devDependencies']['postcss'] = '^8.4.47';
        $packageFileJsonData['devDependencies']['tailwindcss'] = '^3.4.13';
        $packageFileJsonData['devDependencies']['vite'] = '^6.0.11';

        $packageFileJsonData['dependencies']['@vitejs/plugin-vue'] = '^5.2.3';
        $packageFileJsonData['dependencies']['dotenv'] = '^16.4.7';
        $packageFileJsonData['dependencies']['js-cookie'] = '^3.0.5';
        $packageFileJsonData['dependencies']['vue'] = '^3.5.13';
        $packageFileJsonData['dependencies']['vuetify'] = '^3.8.1';

        $files->put($packageJsonFile, json_encode($packageFileJsonData, JSON_PRETTY_PRINT));

        $this->info('package.json modified');
    }

    private function changeBuilderFile(string $fileName, string $ifExistsRegex, string $append): bool
    {
        if (!File::exists($fileName)) {
            File::put($fileName, $append);
        }

        $content = File::get($fileName);

        if (preg_match($ifExistsRegex, $content)) {
            return false;
        }

        return (bool)File::put($fileName, $content."\n\n".$append);
    }
}
