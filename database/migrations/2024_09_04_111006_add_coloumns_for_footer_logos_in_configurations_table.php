<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsForFooterLogosInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->text('footer_logo_one')->nullable();
            $table->string('footer_logo_one_title')->nullable();
            $table->boolean('footer_logo_one_status')->default(0);
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
            $table->dropColumn('footer_logo_one');
            $table->dropColumn('footer_logo_one_title');
            $table->dropColumn('footer_logo_one_status');
        });
    }
}
