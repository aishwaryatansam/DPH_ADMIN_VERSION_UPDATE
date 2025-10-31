<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('document_url');
            $table->unsignedBigInteger('navigation_id');
            $table->string('display_filename');
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->boolean('status');
            $table->boolean('visible_to_public');
            $table->string('reference_no');
            $table->date('dated');
            $table->unsignedBigInteger('uploaded_by');
            $table->softDeletes();
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
        Schema::dropIfExists('documents');
    }
}
