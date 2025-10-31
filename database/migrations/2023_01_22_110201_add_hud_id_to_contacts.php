<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHudIdToContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
              $table->unsignedBigInteger('contact_type')->default(0);
              $table->unsignedBigInteger('hud_id')->nullable();
              $table->unsignedBigInteger('block_id')->nullable();
              $table->unsignedBigInteger('phc_id')->nullable();
              $table->unsignedBigInteger('hsc_id')->nullable();

              $table->index(['contact_type']);
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
            if (Schema::hasColumn('contacts', 'contact_type')){
                $table->dropColumn(['contact_type']);
            }
            if (Schema::hasColumn('contacts', 'hud_id')){
                $table->dropColumn(['hud_id']);
            }
            if (Schema::hasColumn('contacts', 'block_id')){
                $table->dropColumn(['block_id']);
            }
            if (Schema::hasColumn('contacts', 'phc_id')){
                $table->dropColumn(['phc_id']);
            }
            if (Schema::hasColumn('contacts', 'hsc_id')){
                $table->dropColumn(['hsc_id']);
            }
        });
    }
}
