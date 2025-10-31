<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name')->nullable();
            $table->unsignedBigInteger('hud_id')->default(0);
            $table->text('image_url')->nullable();
			$table->boolean('status')->default(1);
			$table->timestamps();
        });

        //Artisan::call('db:seed', array('--class' => 'BlockTableSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
};
