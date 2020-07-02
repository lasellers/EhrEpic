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

    public function savePatients($patients) {
        $patients->asort();
        $iterator = $patients->getIterator();
        $iterator->rewind();
        while($iterator->valid()) {
            $key = $iterator->key();
            $value = json_encode($iterator->current());
            // TODO save
            $iterator->next();
        }

    }

}
