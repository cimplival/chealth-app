<?php

namespace cHealth;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['facility_name', 'ward', 'sub_county', 'county'];

}
