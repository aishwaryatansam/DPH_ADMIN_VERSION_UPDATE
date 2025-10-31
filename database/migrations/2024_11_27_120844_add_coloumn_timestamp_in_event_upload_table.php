<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnTimestampInEventUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_uploads', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable()->after('updated_at');
            $table->timestamp('approved_at')->nullable()->after('updated_at');
            $table->timestamp('published_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_upload', function (Blueprint $table) {
            //
        });
    }
}
