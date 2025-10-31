<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnUserIdInProgramdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            $table->enum('approval_stage', ['pending_verification', 'verified', 'approved', 'published', 'returned_with_remarks', 'rejected_with_remarks'])->default('pending_verification')->after('status');
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programdetails', function (Blueprint $table) {
            //
        });
    }
}
