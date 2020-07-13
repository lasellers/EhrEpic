<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    public string $patientId;
    public string $family;
    public string $given;
    public string $json;

    protected $fillable = [
        'patientId',
        'family',
        'given',
        'json'
    ];

}
