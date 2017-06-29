<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = ['patient_id', 'referral_id', 'institution'];

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }

    public function referral()
    {
        return $this->belongsTo('cHealth\Referral', 'referral_id');
    }
}
