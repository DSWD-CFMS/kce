<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryTable extends Migration {

	public function up()
	{
		// Schema::create('gallery', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('album', 255);
		// });
	}

	public function down()
	{
		Schema::drop('gallery');
	}
}