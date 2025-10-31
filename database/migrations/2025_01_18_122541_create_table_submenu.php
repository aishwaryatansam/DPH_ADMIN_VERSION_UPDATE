<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubmenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submenu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('configuration_content_type_id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('table_submenu');
    }
}
