<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSensorKeyToDataCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_collections', function (Blueprint $table) {
            //
            $table->string('sensor_key')->after('transaction_id')->nullable();
            $table->foreign('sensor_key')
                ->references('key')->on('sensors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_collections', function (Blueprint $table) {
            //
            $table->dropForeign(['sensor_key']);
            $table->dropColumn('sensor_key');
        });
    }
}
