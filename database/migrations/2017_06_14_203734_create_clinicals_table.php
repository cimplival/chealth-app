<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinicals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->text('chief_complaint')->nullable();
            $table->text('review_of_system')->nullable();
            $table->text('pmshx')->nullable();
            $table->text('investigations')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('management')->nullable();
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
        Schema::dropIfExists('clinicals');
    }
}
