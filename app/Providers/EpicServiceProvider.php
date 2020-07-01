<?php

namespace App\Providers;

use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use Illuminate\Support\ServiceProvider;

class EpicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\EpicService', function ($app) {
            return new EpicService();
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
