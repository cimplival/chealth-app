<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = ['patient_id', 'specimen', 'investigation_request', 'status', 'from_user'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }
}
