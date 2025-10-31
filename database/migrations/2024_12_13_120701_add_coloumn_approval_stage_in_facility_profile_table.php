<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnApprovalStageInFacilityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            $table->enum('approval_stage', ['pending_verification', 'verified', 'approved', 'published', 'returned_with_remarks', 'rejected_with_remarks'])->default('pending_verification')->after('hmis');
            $table->text('remarks')->nullable();
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
        Schema::table('facility_profile', function (Blueprint $table) {
            //
        });
    }
}
