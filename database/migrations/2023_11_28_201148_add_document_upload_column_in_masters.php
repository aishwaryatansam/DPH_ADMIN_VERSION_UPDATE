<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentUploadColumnInMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('huds', function (Blueprint $table) {
            $table->text('property_document_url')->nullable();
        });
        Schema::table('blocks', function (Blueprint $table) {
            $table->text('property_document_url')->nullable();
        });
        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->text('property_document_url')->nullable();
        });
        Schema::table('hsc', function (Blueprint $table) {
            $table->text('property_document_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('huds', function (Blueprint $table) {
            $table->dropColumn('property_document_url');
        });
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('property_document_url');
        });
        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->dropColumn('property_document_url');
        });
        Schema::table('hsc', function (Blueprint $table) {
            $table->dropColumn('property_document_url');
        });
        
    }
}
