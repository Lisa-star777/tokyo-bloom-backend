<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Не выполняем запросы к БД при запуске artisan команд (сборка, миграции)
        if ($this->app->runningInConsole()) {
            return;
        }

        // Создать админа если нет
        if (app()->environment('production') && \App\Models\User::where('is_admin', true)->count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'AdminUserSeeder',
                '--force' => true
            ]);
        }
        
        // Создать товары если нет
        if (app()->environment('production') && \App\Models\Product::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'ProductsSeeder',
                '--force' => true
            ]);
        }
    }
}
