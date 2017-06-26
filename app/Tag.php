<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['disease_id', 'name'];

    public function disease()
    {
        return $this->belongsTo('cHealth\Disease', 'disease_id');
    }
}
