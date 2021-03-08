<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssignedGroupingTable extends Migration {

	public function up()
	{
		// Schema::create('assigned_grouping', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->integer('sp_grouping_id');
		// 	$table->integer('assigned_to');
		// });
	}

	public function down()
	{
		Schema::drop('assigned_grouping');
	}
}