<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('whereabouts', function (Blueprint $table) {
        //     // $table->bigIncrements('id');
        //     // $table->timestamps();
        //     // $table->increments('id');
        //     // $table->string('title');
        //     // $table->string('description');
        //     // $table->string('location');
        //     // $table->date('start_date');
        //     // $table->date('end_date');
        //     // $table->integer('user_id');
        //     // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whereabouts');
    }
}
