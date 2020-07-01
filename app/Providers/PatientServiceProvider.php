<?php

namespace App\Providers;

use App\Library\Services\EpicService;
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
//        $this->app->register('\App\Services\EpicService');
//        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
  //      $loader->alias('Breadcrumbs', 'DaveJamesMiller\Breadcrumbs\Facade');

        /** @var EpicService */
  /*      $epicService = $this->app->make('\App\Services\EpicService');
        $this->app->bind('App\Library\Services\PatientService', function ($app) use ($epicService) {
            return new PatientService($epicService);
        });
*/
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
