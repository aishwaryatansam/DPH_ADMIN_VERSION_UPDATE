<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnStatusInEventUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_uploads', function (Blueprint $table) {
            $table->boolean('status')->default(0);
            $table->enum('approval_stage', ['pending_verification', 'verified', 'approved', 'published', 'returned_with_remarks', 'rejected_with_remarks'])->default('pending_verification')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_uploads', function (Blueprint $table) {
            //
        });
    }
}
