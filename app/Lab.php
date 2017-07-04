<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = ['patient_id', 'specimen', 'investigation_request', 'report', 'status', 'from_user'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }

    //Radio_Lab Relationship
    public function radios()
    {
        return $this->belongsToMany('cHealth\Radio')->withTimestamps();
    }


    public function hasRadio($name)
    {
        foreach($this->radios as $radio)
        {
            if($radio->name == $name) return true;
        }
        return false;
    }

    public function assignRadio($radio)
    {
        return $this->radios()->attach($radio);
    }

    public function removeRadio($radio)
    {
        return $this->radios()->detach($radio);
    }
}
