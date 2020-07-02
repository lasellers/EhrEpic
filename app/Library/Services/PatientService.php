<?php

namespace App\Library\Services;

use App\Library\Services\EpicService;
use Illuminate\Support\Facades\App;

class PatientService
{
    protected EpicService $epicService;

    public function __construct()
    {
        $this->epicService = app()->make('App\Library\Services\EpicService');
    }

}
