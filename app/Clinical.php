<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Clinical extends Model
{
    protected $fillable = ['patient_id', 'complaint', 'lab_test', 'treatment'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }
}
