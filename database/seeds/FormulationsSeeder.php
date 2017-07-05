<?php

use Illuminate\Database\Seeder;
use cHealth\Formulation;

class FormulationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formulations')->delete();

        Formulation::create([
            'name'         => 'Tablets'
        ]);

        Formulation::create([
            'name'         => 'Pills'
        ]);

        
    }
}
