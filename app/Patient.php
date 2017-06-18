<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['po_no', 'name', 'age', 'gender', 'phone'];

}