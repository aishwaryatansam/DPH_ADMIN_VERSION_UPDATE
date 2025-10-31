<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnApprovalInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('approval_stage', ['pending_verification', 'verified', 'approved', 'published', 'returned_with_remarks', 'rejected_with_remarks'])->default('pending_verification')->after('status');
            $table->text('remarks')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('updated_at')->after('status');
            $table->timestamp('approved_at')->nullable()->after('updated_at')->after('status');
            $table->timestamp('published_at')->nullable()->after('updated_at')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
}
