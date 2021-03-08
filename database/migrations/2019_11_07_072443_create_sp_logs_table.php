<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpLogsTable extends Migration {

	public function up()
	{
		// Schema::create('sp_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->string('sp_id');
		// 	$table->timestamps();
		// 	$table->integer('sp_logs_planned');
		// 	$table->integer('sp_logs_actual');
		// 	$table->integer('sp_logs_slippage');
		// 	$table->string('sp_logs_variation_order', 255)->default('None');
		// 	$table->string('sp_logs_spcr', 255);
		// 	$table->string('sp_logs_issues', 1000);
		// 	$table->string('sp_logs_analysis', 1000);
		// 	$table->string('sp_logs_remarks', 1000);
		// 	$table->integer('sp_logs_esmr');
		// 	$table->integer('sp_logs_csr');
		// 	$table->string('sp_logs_last_user_update', 50);
		// });
	}

	public function down()
	{
		Schema::drop('sp_logs');
	}
}