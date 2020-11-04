<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_sensors', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('sensor_id');
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_sensors');
    }
}
