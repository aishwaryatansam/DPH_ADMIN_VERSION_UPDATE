<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteContentMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_content_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_content_id');
            $table->unsignedBigInteger('designations_id');
            $table->string('name')->nullable();
            $table->string('qualification')->nullable();
            $table->string('instituttion')->nullable();
            $table->boolean('affiliation')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamps();


            $table->foreign('designations_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('site_content_id')->references('id')->on('site_content')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_content_members');
    }
}
