<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSensorKeyAlgorithmParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('algorithm_parameters', function (Blueprint $table) {
            $table->dropForeign(['sensor_key']);
            $table->dropColumn('sensor_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('algorithm_parameters', function (Blueprint $table) {
            $table->string('sensor_key');
            $table->foreign('sensor_key')
                ->references('key')->on('sensors')
                ->onDelete('cascade');
        });
    }
}
