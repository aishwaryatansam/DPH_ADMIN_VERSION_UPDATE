<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnProgramInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('user_role_id');
            $table->unsignedBigInteger('programs_id')->nullable();
            $table->unsignedBigInteger('sections_id')->nullable();

            $table->index(['user_role_id']);
            $table->foreign('programs_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('sections_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
