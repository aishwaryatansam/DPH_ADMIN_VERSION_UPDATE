<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('designation_id')->default(0);
            $table->string('mobile_number');
            $table->string('landline_number')->nullable();
            $table->string('email_id');
            $table->string('fax')->nullable();
            $table->string('location_url')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['designation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
