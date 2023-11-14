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
        Schema::connection('sqlsrv2')->create('ClubMembersResident', function (Blueprint $table) {
            $table->id();
            $table->string('Block')->nullable();
            $table->string('Street')->nullable();
            $table->string('Plot_no')->nullable();
            $table->integer('ClubMembersId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlsrv2')->dropIfExists('ClubMembersResident');
    }
};
