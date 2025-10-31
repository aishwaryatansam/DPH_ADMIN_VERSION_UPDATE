<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsUrbanToHudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('huds', function (Blueprint $table) {
            $table->string('is_urban')->default(0);
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->string('is_urban')->default(0);
        });

        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->string('is_urban')->default(0);
        });

        Schema::table('hsc', function (Blueprint $table) {
            $table->string('is_urban')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
}
