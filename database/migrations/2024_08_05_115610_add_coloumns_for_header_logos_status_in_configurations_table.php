<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsForHeaderLogosStatusInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('header_logo_one_title')->nullable();
            $table->string('header_logo_two_title')->nullable();
            $table->string('header_logo_three_title')->nullable();
            $table->string('header_logo_four_title')->nullable();
            $table->string('header_logo_five_title')->nullable();
            $table->string('header_logo_six_title')->nullable();
            $table->boolean('header_logo_one_status')->default(0);
            $table->boolean('header_logo_two_status')->default(0);
            $table->boolean('header_logo_three_status')->default(0);
            $table->boolean('header_logo_four_status')->default(0);
            $table->boolean('header_logo_five_status')->default(0);
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
            $table->dropColumn('header_logo_one_title');
            $table->dropColumn('header_logo_two_title');
            $table->dropColumn('header_logo_three_title');
            $table->dropColumn('header_logo_four_title');
            $table->dropColumn('header_logo_five_title');
            $table->dropColumn('header_logo_six_title');
            $table->dropColumn('header_logo_one_status');
            $table->dropColumn('header_logo_two_status');
            $table->dropColumn('header_logo_three_status');
            $table->dropColumn('header_logo_four_status');
            $table->dropColumn('header_logo_five_status');
        });
    }
}
