<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::connection('mysql2')->create('sms_in', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('sms_text', 1600);
        //     $table->string('sender_number', 1600);
        //     $table->dateTime('sent_dt');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('sms_in');
    }
}
