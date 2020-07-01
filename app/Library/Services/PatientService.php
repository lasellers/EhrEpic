<?php

namespace App\Library\Services;

use App\Library\Services\EpicService;
use Illuminate\Support\Facades\App;

class PatientService
{
    protected EpicService $epicService;

    public function __construct() //EpicService $epicService)
    {
        //        $this->epicService = $epicService;
        // $epicService = new EpicService(); // App::make('App\Library\Services\EpicService');
        $this->epicService = app()->make('App\Library\Services\EpicService');
    }

    public function searchPatients($family, $given)
    {
        return $this->epicService->searchPatients($family, $given);
    }

    public function getPatient($patientId)
    {
        return $this->epicService->getPatient($patientId);
    }
}
