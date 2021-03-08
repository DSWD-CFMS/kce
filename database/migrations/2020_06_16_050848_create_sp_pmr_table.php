<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpPmrTable extends Migration {

	public function up()
	{
		// Schema::create('sp_pmr', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('sp_id', 255);
		// 	$table->string('code', 255);
		// 	$table->string('mode_of_procurement');
		// 	$table->string('nature_of_procurement');
		// 	$table->datetime('apa_pre_proc_con');
		// 	$table->datetime('apa_ads');
		// 	$table->datetime('apa_prebid_con');
		// 	$table->datetime('apa_eligibility_check');
		// 	$table->datetime('apa_open_of_bids');
		// 	$table->datetime('apa_bid_eval');
		// 	$table->datetime('apa_post_qual');
		// 	$table->datetime('apa_notice_of_award');
		// 	$table->datetime('apa_contract_signing');
		// 	$table->datetime('apa_notice_to_proceed');
		// 	$table->datetime('apa_contract_review_date');
		// 	$table->datetime('apa_target_date_of_completion');
		// 	$table->datetime('apa_delivery');
		// 	$table->datetime('apa_acceptance');
		// 	$table->datetime('date_contractors_eval_conducted');
		// 	$table->string('fund_source', 255);
		// 	$table->float('abc_total', 10,2);
		// 	$table->float('abc_mooe', 10,2);
		// 	$table->float('abc_co', 10,2);
		// 	$table->float('contract_cost_total', 10,2);
		// 	$table->float('contract_cost_mooe', 10,2);
		// 	$table->float('contract_cost_co', 10,2);
		// 	$table->string('list_of_invited', 2500);
		// 	$table->datetime('io_prebid_con');
		// 	$table->datetime('io_eligibility_check');
		// 	$table->datetime('io_open_of_bids');
		// 	$table->datetime('io_bid_eval');
		// 	$table->datetime('io_post_qual');
		// 	$table->datetime('delivery');
		// 	$table->string('remarks', 2500);
		// 	$table->string('status');
		// });
	}

	public function down()
	{
		// Schema::drop('sp_pmr');
	}
}