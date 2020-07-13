<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public string $patientId;
    public string $practitionerId;
    public string $comment;

    protected $fillable = [
        'patientId',
        'practitionerId',
        'comment'
    ];
}
