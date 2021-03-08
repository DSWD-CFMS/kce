<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpCycleTable extends Migration {

	public function up()
	{
		// Schema::create('sp_cycle', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('cycle');
		// });
	}

	public function down()
	{
		Schema::drop('sp_cycle');
	}
}