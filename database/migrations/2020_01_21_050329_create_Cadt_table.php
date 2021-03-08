<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCadtTable extends Migration {

	public function up()
	{
		// Schema::create('Cadt', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('sp_id', 200);
		// 	$table->string('cadt_no', 200);
		// });
	}

	public function down()
	{
		Schema::drop('Cadt');
	}
}