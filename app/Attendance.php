<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['patient_id', 'clinical_id', 'status'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }

    public function clinical()
    {
        return $this->belongsTo('cHealth\Clinical', 'clinical_id');
    }
}
