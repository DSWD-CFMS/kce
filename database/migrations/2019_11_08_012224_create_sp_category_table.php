<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpCategoryTable extends Migration {

	public function up()
	{
		// Schema::create('sp_category', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->integer('grouping_id');
		// 	$table->string('category', 255);
		// });
	}

	public function down()
	{
		Schema::drop('sp_category');
	}
}