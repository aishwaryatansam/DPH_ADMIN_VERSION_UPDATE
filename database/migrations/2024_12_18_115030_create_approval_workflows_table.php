<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->unsignedBigInteger('uploaded_by')->nullable();

            $table->unsignedBigInteger('phc_verify_id')->nullable();
            $table->timestamp('phc_verify_at')->nullable();

            $table->unsignedBigInteger('block_verify_id')->nullable();
            $table->timestamp('block_verify_at')->nullable();

            $table->unsignedBigInteger('block_approve_id')->nullable();
            $table->timestamp('block_approve_at')->nullable();

            $table->unsignedBigInteger('hud_verify_id')->nullable();
            $table->timestamp('hud_verify_at')->nullable();

            $table->unsignedBigInteger('hud_approve_id')->nullable();
            $table->timestamp('hud_approve_at')->nullable();

            $table->unsignedBigInteger('state_verify_id')->nullable();
            $table->timestamp('state_verify_at')->nullable();

            $table->unsignedBigInteger('state_approve_id')->nullable();
            $table->timestamp('state_approve_at')->nullable();

            $table->unsignedBigInteger('super_admin_id')->nullable();

            $table->enum('current_stage', ['hsc_upload', 'phc_upload', 'phc_verify', 'block_upload', 'block_verify', 'block_approve', 'hud_upload', 'hud_verify', 'hud_approve', 'district_uplaod', 'state_upload', 'state_verify', 'state_approve', 'published', 'returned_with_remarks', 'rejected_with_remarks']);
            $table->text('remarks')->nullable();
            
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('phc_verify_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('block_verify_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('block_approve_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hud_verify_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hud_approve_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_verify_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_approve_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('super_admin_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('approval_workflows');
    }
}
