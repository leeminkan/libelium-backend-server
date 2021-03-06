<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    
    protected $repositories = [
        "App\Repositories\Interfaces\BaseRepository" => "App\Repositories\BaseRepository",
        "App\Repositories\Interfaces\UserRepository" => "App\Repositories\UserRepository",
        "App\Repositories\Interfaces\DeviceRepository" => "App\Repositories\DeviceRepository",
        "App\Repositories\Interfaces\DataCollectionRepository" => "App\Repositories\DataCollectionRepository",
        "App\Repositories\Interfaces\AlgorithmParameterRepository" => "App\Repositories\AlgorithmParameterRepository",
        "App\Repositories\Interfaces\SettingRepository" => "App\Repositories\SettingRepository",
        "App\Repositories\Interfaces\SensorRepository" => "App\Repositories\SensorRepository",
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Repositories
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
