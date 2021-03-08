<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration {

	public function up()
	{
		// Schema::create('files', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('filename', 255);
		// 	$table->string('path', 255);
		// 	$table->integer('origin');
		// 	$table->string('category', 255);
		// });
	}

	public function down()
	{
		Schema::drop('files');
	}
}