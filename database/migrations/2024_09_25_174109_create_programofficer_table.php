<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramofficerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programofficer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->text('qualification')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('designations_id')->default(0);
            $table->unsignedBigInteger('programs_id')->default(0);
            $table->timestamps();

            $table->foreign('designations_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('programs_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programofficer');
    }
}
