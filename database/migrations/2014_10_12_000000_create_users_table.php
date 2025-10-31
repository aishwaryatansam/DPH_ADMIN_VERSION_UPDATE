<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedSmallInteger('user_type_id');
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->unsignedBigInteger('section')->default(0);
            $table->text('designation')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('country_code')->default('+91');
            $table->string('otp')->nullable();
            $table->dateTime('last_otp_verified_at')->nullable();
            $table->boolean('status')->default(0);            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_type_id','contact_number']);
        });

        Artisan::call('db:seed', array('--class' => 'UserSeeder'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
