<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsForHeaderTextSettingsInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('tamilnadu_government_title_tamil')->nullable();
            $table->string('tamilnadu_government_title_english')->nullable();
            $table->string('dph_full_form_tamil')->nullable();
            $table->string('dph_full_form_english')->nullable();
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
            $table->dropColumn('tamilnadu_government_title_tamil');
            $table->dropColumn('tamilnadu_government_title_english');
            $table->dropColumn('dph_full_form_tamil');
            $table->dropColumn('dph_full_form_english');
        });
    }
}
