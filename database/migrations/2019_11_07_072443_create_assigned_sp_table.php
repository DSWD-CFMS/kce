<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssignedSpTable extends Migration {

	public function up()
	{
		// Schema::create('assigned_sp', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('sp_id', 255);
		// 	$table->integer('assigned_to');
		// });
	}

	public function down()
	{
		Schema::drop('assigned_sp');
	}
}