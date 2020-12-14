<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlgorithmParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('algorithm_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('waspmote_id');
            $table->foreign('waspmote_id')
                ->references('waspmote_id')->on('devices')
                ->onDelete('cascade');
            $table->string('sensor_key');
            $table->foreign('sensor_key')
                ->references('key')->on('sensors')
                ->onDelete('cascade');
            $table->string('window_size');
            $table->string('saving_level');
            $table->string('time_base');
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
        Schema::dropIfExists('algorithm_parameters');
    }
}
