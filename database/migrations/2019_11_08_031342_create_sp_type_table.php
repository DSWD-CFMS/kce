<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpTypeTable extends Migration {

	public function up()
	{
		// Schema::create('sp_type', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('type');
		// });
	}

	public function down()
	{
		Schema::drop('sp_type');
	}
}