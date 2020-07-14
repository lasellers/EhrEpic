<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPractitioner extends Model
{
    //
    public string $patientId;
    public string $practitioner;

    protected $fillable = [
        'patientId',
        'practitioner',
    ];

}
