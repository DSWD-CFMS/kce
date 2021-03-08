<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryImagesTable extends Migration {

	public function up()
	{
		// Schema::create('gallery_images', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('gallery_id');
		// 	$table->string('filename');
		// 	$table->string('path');
		// });
	}

	public function down()
	{
		Schema::drop('gallery_images');
	}
}