<?php

namespace App\Library\Services;

class EpicService
{
    public function getPatients()
    {
        $patients = [['test', 'doe'], ['bob', 'smith']];

        $iterator = new \ArrayObject($patients);

        $patients = iterator_to_array($iterator);
        print_r($patients);

        return $patients;
    }
}
