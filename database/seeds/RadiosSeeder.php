<?php

use Illuminate\Database\Seeder;
use cHealth\Radio;

class RadiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('radios')->delete();

        Radio::create([
            'name' => 'X-rays'
        ]);

        Radio::create([
            'name' => 'Ultrasound'
        ]);

        Radio::create([
            'name' => 'CT-Scan'
        ]);

        Radio::create([
            'name' => 'ECG'
        ]);

        Radio::create([
            'name' => 'Dental X-ray'
        ]);

        Radio::create([
            'name' => 'MRI'
        ]);

        
    }
}
