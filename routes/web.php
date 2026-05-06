<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        return "✅ Подключение успешно! База данных: " . $dbName;
    } catch (\Exception $e) {
        return "❌ Ошибка подключения: " . $e->getMessage();
    }
});

Route::get('/', function () {
    return view('welcome');
});
