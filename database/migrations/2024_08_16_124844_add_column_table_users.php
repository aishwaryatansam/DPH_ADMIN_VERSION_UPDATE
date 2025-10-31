<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('block_id')->nullable();
            $table->unsignedBigInteger('phc_id')->nullable();
            $table->unsignedBigInteger('hsc_id')->nullable();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');
            $table->foreign('phc_id')->references('id')->on('p_h_c_s')->onDelete('set null');
            $table->foreign('hsc_id')->references('id')->on('hsc')->onDelete('set null');

            $table->index(['district_id, block_id, phc_id, hsc_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the foreign keys and columns
            $table->dropForeign(['district_id']);
            $table->dropForeign(['block_id']);
            $table->dropForeign(['phc_id']);
            $table->dropForeign(['hsc_id']);
            
            // Dropping the columns
            $table->dropColumn(['district_id', 'block_id', 'phc_id', 'hsc_id']);
        });
    }
}