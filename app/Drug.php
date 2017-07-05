<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = ['name', 'formulation_id', 'stock'];

    public function formulation()
    {
        return $this->belongsTo('cHealth\Formulation');
    }
}
