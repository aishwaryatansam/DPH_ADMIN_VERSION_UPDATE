<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtiPdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rti_pdfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name'); // Name of the uploaded file
            $table->string('file_path'); // Path where the file is stored
            $table->date('upload_date'); // Date of upload
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
        Schema::dropIfExists('rti_pdfs');
    }
}
