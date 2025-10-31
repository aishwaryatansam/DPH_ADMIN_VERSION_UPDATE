<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnScrollerNotificationInSiteContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_content', function (Blueprint $table) {
            $table->string('contact_description')->nullable();
            $table->string('scroller_notification_name')->nullable();
            $table->string('scroller_notification_link')->nullable();
            $table->string('email')->nullable();
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
