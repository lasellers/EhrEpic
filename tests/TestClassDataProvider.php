<?php
/*
*/

namespace Tests;

use App\Models\User;
use App\Models\Patient;
use App\Http\Controllers\PatientController;

/**
 */
trait TestClassDataProvider
{

    /**
     * @return array
     */
    public function modelsDataProvider()
    {
        return [
            [Patient::class],
        ];
    }

    /**
     * @return array
     */
    public function modelFiltersDataProvider()
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function controllerDataProvider()
    {
        return [
            [PatientController::class, []],
        ];
    }
}
