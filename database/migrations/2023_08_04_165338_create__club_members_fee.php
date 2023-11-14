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
        Schema::connection('sqlsrv2')->create('ClubMembersFee', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('user_id');
            $table->integer('FeeAmount');
            $table->string('FeeDate');
            $table->string('Status');
            $table->timestamp('CreatedAt');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlsrv2')->dropIfExists('ClubMembersFee');
    }
};
