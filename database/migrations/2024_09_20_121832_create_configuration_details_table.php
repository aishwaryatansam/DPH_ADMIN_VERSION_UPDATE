<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('link')->nullable();
            $table->boolean('status')->default(1);
            $table->text('image_url')->nullable();
            $table->unsignedBigInteger('configuration_content_type_id');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('configuration_content_type_id')->references('id')->on('configuration_content_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuration_details');
    }
}
