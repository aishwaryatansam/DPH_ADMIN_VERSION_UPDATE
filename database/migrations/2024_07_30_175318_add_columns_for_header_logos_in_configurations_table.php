<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForHeaderLogosInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->text('header_logo_one')->nullable();
            $table->text('header_logo_two')->nullable();
            $table->text('header_logo_three')->nullable();
            $table->text('header_logo_four')->nullable();
            $table->text('header_logo_five')->nullable();
            $table->text('header_logo_six')->nullable();
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
            $table->dropColumn('header_logo_one');
            $table->dropColumn('header_logo_two');
            $table->dropColumn('header_logo_three');
            $table->dropColumn('header_logo_four');
            $table->dropColumn('header_logo_five');
            $table->dropColumn('header_logo_six');
        });
    }
}
