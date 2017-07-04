<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadioLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_radio', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('radio_id')->unsigned()->index();
            $table->foreign('radio_id')->references('id')->on('radios')->onDelete('cascade');
            
            $table->integer('lab_id')->unsigned()->index();
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_radio');
    }
}
