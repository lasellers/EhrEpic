<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    public int $patient_id = 0;
    public int $practitioner_id = 0;
    public string $comment;

    protected $fillable = [
        'patient_id',
        'practitioner_id',
        'comment'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
        //return $this->belongsTo(Patient::class, 'patient_id', 'id'); //todo debug
    }

    public function practitioner(): HasOne
    {
        return $this->hasOne(Practitioner::class, 'id', 'practitioner_id');
        //return $this->belongsTo(Practitioner::class); //, 'practitioner_id', 'id'); todo debug
    }

}
