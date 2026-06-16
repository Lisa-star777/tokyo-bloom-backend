<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {}

            try {
                if (\App\Models\User::where('is_admin', true)->count() === 0) {
                    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AdminUserSeeder', '--force' => true]);
                }
            } catch (\Exception $e) {}
        }
    }
}
