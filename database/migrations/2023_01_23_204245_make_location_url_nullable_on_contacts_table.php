<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLocationUrlNullableOnContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::table('contacts', function (Blueprint $table) {
             $table->string('location_url')->nullable();
             $table->string('landline_number')->nullable();
             $table->string('image_url')->nullable();
             $table->string('fax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
             $table->dropColumn(['location_url','landline_number','image_url','fax']);
        });
    }
}
