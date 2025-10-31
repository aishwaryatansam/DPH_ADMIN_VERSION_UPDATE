<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtiOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rti_officers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('mobile_number')->nullable();
            $table->text('landline_number')->nullable();
            $table->text('extn')->nullable();
            $table->text('fax')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('designations_id');
            $table->foreign('designations_id')->references('id')->on('designations')->onDelete('cascade');
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
        Schema::dropIfExists('rti_officers');
    }
}
