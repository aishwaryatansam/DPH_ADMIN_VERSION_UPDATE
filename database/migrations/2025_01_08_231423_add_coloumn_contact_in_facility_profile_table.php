<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnContactInFacilityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            $table->boolean('area_type')->default(1)->after('hmis');
            $table->string('mobile_number')->nullable()->after('hmis');
            $table->string('landline_number')->nullable()->after('hmis');
            $table->string('email_id')->nullable()->after('hmis');
            $table->string('fax')->nullable()->after('hmis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            //
        });
    }
}
