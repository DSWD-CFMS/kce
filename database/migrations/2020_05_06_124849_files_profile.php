<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilesProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('files_profile', function(Blueprint $table) {
        //     $table->increments('id');
        //     $table->timestamps();
        //     $table->string('filename', 255);
        //     $table->string('path', 255);
        //     $table->integer('origin');
        //     $table->string('category', 255);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files_profile');
    }
}
