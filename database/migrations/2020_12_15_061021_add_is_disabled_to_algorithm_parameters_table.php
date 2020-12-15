<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDisabledToAlgorithmParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('algorithm_parameters', function (Blueprint $table) {
            //
            $table->boolean('is_disabled')->after('waspmote_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('algorithm_parameters', function (Blueprint $table) {
            //
            $table->dropColumn('is_disabled');
        });
    }
}
