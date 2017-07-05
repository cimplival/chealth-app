<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drug_id')->unsigned();
            $table->foreign('drug_id')->references('id')
             ->on('drugs')->onDelete('cascade');
            $table->integer('clinical_id')->unsigned();
            $table->foreign('clinical_id')->references('id')
             ->on('clinicals')->onDelete('cascade');
            $table->double('quantity');
            $table->integer('times_a_day');
            $table->integer('no_of_days');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('medications');
    }
}
