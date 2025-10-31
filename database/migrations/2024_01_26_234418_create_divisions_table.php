<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('division_icon')->nullable();
            $table->string('division_head_name_one')->nullable();
            $table->string('division_head_name_two')->nullable();
            $table->string('division_head_name_three')->nullable();
            
            $table->string('division_head_image_one')->nullable();
            $table->string('division_head_image_two')->nullable();
            $table->string('division_head_image_three')->nullable();

            $table->unsignedBigInteger('parent_division_id')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('order_no')->nullable();
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
        Schema::dropIfExists('divisions');
    }
}
