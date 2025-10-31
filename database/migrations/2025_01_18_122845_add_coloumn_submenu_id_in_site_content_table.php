<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnSubmenuIdInSiteContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_content', function (Blueprint $table) {
            $table->unsignedBigInteger('submenu_id')->nullable()->after('configuration_content_type_id');
            
            $table->foreign('submenu_id')->references('id')->on('submenu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_content', function (Blueprint $table) {
            //
        });
    }
}
