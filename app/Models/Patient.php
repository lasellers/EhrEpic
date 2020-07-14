<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    public string $patientId;
    public string $family;
    public string $birthDate;
    public string $birthSex;
    public string $sex;
    public string $address;
    public string $telecom;
    public string $race;
    public string $ethnicity;

    public string $json;

    protected $fillable = [
        'patientId',
        'family',
        'given',
        'json'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function conditions()
    {
        return $this->hasMany(Condition::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }

}
