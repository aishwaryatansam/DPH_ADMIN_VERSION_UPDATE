<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAntiCurruptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anti_curruption', function (Blueprint $table) {
            // Remove existing columns
            $table->dropColumn('description');
            $table->dropColumn('address');

            // Add new columns
            $table->string('tamildescription')->after('id');
            $table->string('englishdescription')->after('tamildescription');
            $table->string('tamiladdress')->after('englishdescription');
            $table->string('englishaddress')->after('tamiladdress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anti_curruption', function (Blueprint $table) {
            // Re-add the removed columns
            $table->string('description')->after('id');
            $table->string('address')->after('description');

            // Remove the newly added columns
            $table->dropColumn(['tamildescription', 'englishdescription', 'tamiladdress', 'englishaddress']);
        });
    }
}
