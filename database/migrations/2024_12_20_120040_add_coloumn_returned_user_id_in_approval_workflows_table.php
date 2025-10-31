<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnReturnedUserIdInApprovalWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approval_workflows', function (Blueprint $table) {
            $table->unsignedBigInteger('returned_user_id')->nullable();
            $table->unsignedBigInteger('rejected_user_id')->nullable();
            
            $table->foreign('returned_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rejected_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_workflows', function (Blueprint $table) {
            //
        });
    }
}
