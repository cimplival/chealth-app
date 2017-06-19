<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['op_no', 'name', 'age', 'gender', 'phone'];

}