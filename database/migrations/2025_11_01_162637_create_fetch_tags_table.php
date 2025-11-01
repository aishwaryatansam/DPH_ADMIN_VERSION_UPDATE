<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('fetch_tags')) {
            Schema::table('fetch_tags', function (Blueprint $table) {
                if (!Schema::hasColumn('fetch_tags', 'name')) {
                    $table->string('name')->after('id');
                }
             
                if (!Schema::hasColumn('fetch_tags', 'status')) {
                    $table->boolean('status')->default(1)->after('slug_key');
                }
            });
        } else {
            Schema::create('fetch_tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
             
                $table->boolean('status');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('fetch_tags')) {
            Schema::table('fetch_tags', function (Blueprint $table) {
                if (Schema::hasColumn('fetch_tags', 'name')) {
                    $table->dropColumn('name');
                }
                
                if (Schema::hasColumn('fetch_tags', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
