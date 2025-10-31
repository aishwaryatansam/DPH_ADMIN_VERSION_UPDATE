<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('configuration_content_type_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('thumbnail_name')->nullable();
            $table->string('souvenir_name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('document_url')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('visible_to_public')->default(1);
            $table->timestamps();

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
        Schema::dropIfExists('site_content');
    }
}
