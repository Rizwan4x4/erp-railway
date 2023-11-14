<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('emp_code')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_password');
            $table->string('user_role')->nullable();
            $table->string('company_id')->nullable();
            $table->string('u_status')->nullable();
            $table->string('department')->nullable();
            $table->string('tour_status')->nullable();
            $table->string('photo')->nullable();
            $table->string('update_sender')->nullable();
            $table->string('UserType')->nullable();
            $table->string('login_status')->nullable();
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
};
