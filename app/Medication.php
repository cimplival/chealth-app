<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = ['drug_id', 'clinical_id', 'quantity', 'times_a_day', 'no_of_days', 'status'];

    public function drug()
    {
        return $this->belongsTo('cHealth\Drug');
    }

    public function clinical()
    {
        return $this->belongsTo('cHealth\Clinical');
    }
}
