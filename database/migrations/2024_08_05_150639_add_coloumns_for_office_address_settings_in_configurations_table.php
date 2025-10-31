<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsForOfficeAddressSettingsInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('dph_address')->nullable();
            $table->string('dph_zip_code')->nullable();
            $table->string('dph_city')->nullable();
            $table->string('dph_state')->nullable();
            $table->string('dph_phone')->nullable();
            $table->string('joint_director_email')->nullable();
            $table->string('joint_director_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('dph_address');
            $table->dropColumn('dph_zip_code');
            $table->dropColumn('dph_city');
            $table->dropColumn('dph_state');
            $table->dropColumn('dph_phone');
            $table->dropColumn('joint_director_email');
            $table->dropColumn('joint_director_phone');
        });
    }
}
