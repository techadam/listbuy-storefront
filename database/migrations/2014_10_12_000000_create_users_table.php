<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_info_id')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->enum('user_type', ['seller', 'buyer', 'admin']);
            $table->string('password');
            $table->string('phone');
            $table->string("country_code");
            $table->integer('password_reset_code')->nullable();
            $table->integer('phone_otp')->nullable();
            $table->string('email_token')->nullable();
            $table->boolean('verified')->default(false);
            $table->boolean('email_is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
