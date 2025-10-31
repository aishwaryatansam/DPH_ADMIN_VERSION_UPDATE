<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteContentBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_content_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_content_id');
            $table->string('name')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('status')->default(1);
            $table->text('order_no')->nullable();
            $table->timestamps();

            $table->foreign('site_content_id')->references('id')->on('site_content')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_content_banners');
    }
}
