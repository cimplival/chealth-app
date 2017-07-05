<?php

use Illuminate\Database\Seeder;
use cHealth\Drug;

class DrugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drugs')->delete();

        Drug::create([
            'name'            => 'Paracetamols',
            'formulation_id'  => '1',
            'stock'           => 50
        ]);

    }
}
