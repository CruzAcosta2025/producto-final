<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'timezone' => 'America/Lima',



    'name' => env('APP_NAME', 'Laravel'),


    'env' => env('APP_ENV', 'production'),


    'debug' => (bool) env('APP_DEBUG', false),


    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    'timezone' => 'America/Lima',

    'locale' => 'en',


    'fallback_locale' => 'en',

    'faker_locale' => 'en_US',


    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',


    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],



    'providers' => ServiceProvider::defaultProviders()->merge([

        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        // Maatwebsite\Excel\ExcelServiceProvider::class,

    ])->toArray(),


    'aliases' => Facade::defaultAliases()->merge([
        'Pdf' => Barryvdh\DomPDF\Facade\Pdf::class,
        //'PDF' => \Barryvdh\DomPDF\Facade::class,
        //'Excel' => \Maatwebsite\Excel\Facades\Excel::class

    ])->toArray(),


];
