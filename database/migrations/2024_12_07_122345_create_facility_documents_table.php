<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_profile_id')->nullable();
            $table->text('document_url')->nullable();
            $table->text('document_name')->nullable();

            $table->foreign('facility_profile_id')->references('id')->on('facility_profile')->onDelete('cascade');
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
        Schema::dropIfExists('facility_documents');
    }
}
