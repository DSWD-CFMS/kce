<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpPmrLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sp_pmr_logs', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->timestamps();
        //     $table->bigInteger('pmr_id');
        //     $table->string('pmr_comments', 2500);
        //     $table->string('status', 25);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_pmr_logs');
    }
}
