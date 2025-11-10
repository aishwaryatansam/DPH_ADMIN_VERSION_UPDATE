<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FetchTag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];
    protected $table = 'fetch_tags';

    public static function ensureTable()
    {
        if (!Schema::hasTable('fetch_tags')) {
            Schema::create('fetch_tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        } else {
            Schema::table('fetch_tags', function (Blueprint $table) {
                if (!Schema::hasColumn('fetch_tags', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('fetch_tags', 'status')) {
                    $table->boolean('status')->default(1);
                }
            });
        }
    }
}
