<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionAndAddDateToconfigurationDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuration_details', function (Blueprint $table) {
            $table->text('description')->nullable(); // Add 'description' column
            $table->date('date')->nullable();        // Add 'date' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuration_details', function (Blueprint $table) {
            $table->dropColumn(['description', 'date']); // Rollback the columns
        });
    }
}
