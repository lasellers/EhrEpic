<?php

namespace App\Providers;

use App\Library\Services\PatientService;
use Illuminate\Support\ServiceProvider;

class PatientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\PatientService', function ($app) {
            return new PatientService();
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
