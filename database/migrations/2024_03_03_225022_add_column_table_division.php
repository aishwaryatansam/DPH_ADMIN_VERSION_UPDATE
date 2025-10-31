<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->boolean('designation_id_one')->nullable();
            $table->boolean('designation_id_two')->nullable();
            $table->boolean('designation_id_three')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('designation_id_one');
            $table->dropColumn('designation_id_two');
            $table->dropColumn('designation_id_three');
        });
    }
}
