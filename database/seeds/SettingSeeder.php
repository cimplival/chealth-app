<?php

use Illuminate\Database\Seeder;
use cHealth\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diseases')->delete(); 

        Setting::create([
   			'facility_name' => 'Pangani Hospital',
   			'ward'          => 'Pangani ward' ,
   			'sub_county'    => 'Starehe',
   			'county'        => 'Nairobi'
    	]);
    }
}
