<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFacilityHierarchyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_hierarchy', function (Blueprint $table) {
            // Drop the country_id and state_id columns
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');

            // Make facility_code nullable
            $table->string('facility_code')->nullable()->change();
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
    }
}
