<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class DiseaseCount extends Model
{
    protected $table = 'diseases_counts';

    protected $fillable = ['disease_id', 'patient_id', 'tag_id', 'from_user'];

    public function disease()
    {
        return $this->belongsTo('cHealth\Disease', 'disease_id');
    }

    public function patient()
    {
        return $this->belongsTo('cHealth\Patient', 'patient_id');
    }

    public function tag()
    {
        return $this->belongsTo('cHealth\Tag', 'tag_id');
    }

}	
