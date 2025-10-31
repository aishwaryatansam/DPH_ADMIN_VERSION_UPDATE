<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('document_type_id');
            $table->unsignedBigInteger('scheme_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('document_url')->nullable();
            $table->string('reference_no')->nullable();
            $table->date('dated')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('publication_type_id')->nullable();
            $table->unsignedBigInteger('notification_type_id')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('image_url')->nullable();
            $table->string('financial_year')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->boolean('status')->default(1); 
            $table->boolean('visible_to_public')->default(1);
            $table->timestamps();

            $table->foreign('document_type_id')->references('id')->on('document_type')->onDelete('cascade');
            $table->foreign('publication_type_id')->references('id')->on('masters')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('masters')->onDelete('cascade');
            $table->foreign('notification_type_id')->references('id')->on('masters')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('scheme_id')->references('id')->on('schemes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_documents');
    }
}
