<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Waiting extends Model
{
    protected $fillable = ['patient_id', 'status'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }
}
