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
        Schema::connection('sqlsrv2')->create('Clubs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('update_by')->nullable();
            $table->string('Name');
            $table->string('Type');
            $table->string('Employee_fee');
            $table->string('Resident_fee');
            $table->string('Outsider_fee');
            $table->string('Description');
            $table->string('status');
            $table->boolean('IsDeleted')->nullable();
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
        Schema::connection('sqlsrv2')->dropIfExists('Clubs');
    }
};
