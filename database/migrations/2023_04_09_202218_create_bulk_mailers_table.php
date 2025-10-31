<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkMailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('bulk_mailers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('to');
            $table->longText('cc')->nullable();
            $table->longText('subject');
            $table->longText('message_content');
            $table->dateTime('send_at')->nullable();
            $table->dateTime('triggered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_mailers');
    }
}
