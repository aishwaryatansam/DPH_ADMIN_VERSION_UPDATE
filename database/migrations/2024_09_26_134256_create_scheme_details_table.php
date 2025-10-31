<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('scheme_details', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('schemes_id');
        $table->string('name'); // Name of the scheme
        $table->text('description'); // Description of the scheme
        $table->text('document_url');

        // Columns for scheme images
        $table->string('image_one')->nullable();
        $table->string('image_two')->nullable();
        $table->string('image_three')->nullable();
        $table->string('image_four')->nullable();
        $table->string('image_five')->nullable();

        // Columns for report images
        $table->string('report_image_one')->nullable();
        $table->string('report_image_two')->nullable();
        $table->string('report_image_three')->nullable();
        $table->string('report_image_four')->nullable();
        $table->string('report_image_five')->nullable();

        $table->boolean('visible_to_public')->default(0);
        $table->boolean('status')->default(1);
        $table->timestamps();

        $table->foreign('schemes_id')
              ->references('id')
              ->on('schemes')
              ->onDelete('cascade');

        // 👇 Add unique constraint to prevent duplicates
        $table->unique(['schemes_id', 'name'], 'unique_scheme_details');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheme_details');
    }
}
