<?php

namespace App\Library\Services;

class PatientService
{
    public function getPatients()
    {
        $patients = [['test', 'doe'], ['bob', 'smith']];
        return $patients;
    }
}
