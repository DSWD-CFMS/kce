<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpTable extends Migration {

	public function up()
	{
		// Schema::create('sp', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->integer('sp_groupings')->unsigned();
		// 	$table->string('sp_id', 255);
		// 	$table->string('sp_title', 255);
		// 	$table->integer('sp_category');
		// 	$table->string('sp_province', 50);
		// 	$table->string('sp_municipality', 50);
		// 	$table->string('sp_brgy', 50);
		// 	$table->integer('sp_building_permit')->default('0');
		// 	$table->string('sp_physical_target', 255);
		// 	$table->float('sp_project_cost');
		// 	$table->datetime('sp_rfr_first_tranche_date');
		// 	$table->datetime('sp_date_started');
		// 	$table->string('sp_estimated_duration');
		// 	$table->datetime('sp_target_date_of_completion');
		// 	$table->string('sp_days_suspended')->default('0');
		// 	$table->datetime('sp_actual_date_completed');
		// 	$table->datetime('sp_date_of_turnover');
		// 	$table->integer('sp_fullblown_proposal')->default('0');
		// 	$table->string('sp_cycle');
		// 	$table->string('sp_batch');
		// });
	}

	public function down()
	{
		Schema::drop('sp');
	}
}