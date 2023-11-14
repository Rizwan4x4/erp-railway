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
        Schema::connection('sqlsrv2')->create('ClubMembers', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->nullable();
            $table->string('Cnic')->nullable();
            $table->string('PhoneNo')->nullable();
            $table->string('Email')->nullable();
            $table->string('employee_code')->nullable();
            $table->string('Address')->nullable();
            $table->string('m_type')->nullable();
            $table->integer('club_id')->nullable();

            $table->string('Status')->nullable();
            $table->string('user_id');
            $table->string('update_by')->nullable();
            $table->timestamp('CreatedAt');
            $table->timestamp('UpdateAt')->nullable();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlsrv2')->dropIfExists('ClubMembers');
    }
};
