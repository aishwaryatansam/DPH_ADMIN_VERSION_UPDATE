<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventTypeIdInNewDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->foreign('event_type_id')->references('id')->on('masters')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_documents', function (Blueprint $table) {
            //
        });
    }
}
