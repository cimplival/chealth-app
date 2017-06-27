<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['op_no', 'name', 'age', 'gender', 'phone', 'physical_address'];

    public function diseasecount()
	{
	    return $this->hasMany('cHealth\DiseaseCount');
	}

	public function attendance()
	{
	    return $this->hasMany('cHealth\Attendance');
	}

}