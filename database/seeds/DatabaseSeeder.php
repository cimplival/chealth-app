<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('DiseasesSeeder');
        $this->call('TagsSeeder');
        $this->call('SettingSeeder');
        $this->call('RadiosSeeder');
        $this->call('FormulationsSeeder');
        $this->call('DrugsSeeder');

        Model::reguard();
    }
}
