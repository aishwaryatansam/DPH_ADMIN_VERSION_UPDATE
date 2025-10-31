<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiCurruptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anti_curruption', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tamildescription')->nullable();
            $table->text('englishdescription')->nullable();
            $table->text('tamiladdress')->nullable();
            $table->text('englishaddress')->nullable();
            $table->text('website')->nullable();
            $table->text('fax_number')->nullable();
            $table->text('phone_number')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('anti_curruption');
    }
}
