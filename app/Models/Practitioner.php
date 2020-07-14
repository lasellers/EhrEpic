<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    //
    public string $patient_id;
    public string $practitioner_id;
    public string $patientId;
    public string $practitionerId;

    protected $fillable = [
        'patient_id',
        'practitioner_id',
        'patientId',
        'practitionerId',
    ];

}
