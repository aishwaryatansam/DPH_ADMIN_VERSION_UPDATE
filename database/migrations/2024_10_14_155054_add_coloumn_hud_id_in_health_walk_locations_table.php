<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnHudIdInHealthWalkLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_walk_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('hud_id')->nullable();
            $table->text('area')->nullable();
            $table->text('description')->nullable();
            $table->text('start_point')->nullable();
            $table->text('end_point')->nullable();

            $table->foreign('hud_id')->references('id')->on('huds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_walk_locations', function (Blueprint $table) {
            //
        });
    }
}
