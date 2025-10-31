<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('media_gallery'); // 1 for image, 2 for audio, 3 for video
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->boolean('status')->default(1); // 1 for active, 0 for inactive
            $table->string('image')->nullable(); // For storing image path
            $table->string('url')->nullable(); // For storing audio/video URL
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
        Schema::dropIfExists('media_gallery');
    }
}
