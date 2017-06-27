<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Clinical extends Model
{
    protected $fillable = ['patient_id', 'chief_complaint', 'review_of_system', 'pmshx', 'investigations', 'diagnosis', 'management'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }

    public function attendance()
	{
	    return $this->hasMany('cHealth\Attendance');
	}
}
