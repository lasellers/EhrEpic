<?php

namespace App\Library\Services;

use App\Library\Services\EpicService;
use Illuminate\Support\Facades\App;

class PatientService
{
    protected EpicService $epicService;

    /*    public function __construct(EpicService $epicService)
        {
            $this->epicService = $epicService;
        }
    */
    public function getPatients()
    {
        $epicService = App::make('App\Library\Services\EpicService');
        $patients = $epicService->getPatients();
        return $patients;
    }
}
