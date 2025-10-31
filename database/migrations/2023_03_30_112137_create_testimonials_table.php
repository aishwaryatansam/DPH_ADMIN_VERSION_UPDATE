<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('designation')->nullable();
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->uuid('unique_key')->nullable();
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
        Schema::dropIfExists('testimonials');
    }
}
