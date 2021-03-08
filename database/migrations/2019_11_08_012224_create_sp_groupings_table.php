<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpGroupingsTable extends Migration {

	public function up()
	{
		// Schema::create('sp_groupings', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('grouping', 255);
		// });
	}

	public function down()
	{
		Schema::drop('sp_groupings');
	}
}