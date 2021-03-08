<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpBatchTable extends Migration {

	public function up()
	{
		// Schema::create('sp_batch', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('batch');
		// });
	}

	public function down()
	{
		Schema::drop('sp_batch');
	}
}