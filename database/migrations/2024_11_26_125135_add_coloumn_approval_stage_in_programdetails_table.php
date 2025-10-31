<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnApprovalStageInProgramdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programdetail', function (Blueprint $table) {
            $table->enum('approval_stage', ['pending_verification', 'verified', 'approved', 'published', 'returned_with_remarks', 'rejected_with_remarks'])->default('pending_verification')->after('status');
            $table->text('remarks')->nullable();
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
