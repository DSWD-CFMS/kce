<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCeacTable extends Migration {

	public function up()
	{
		// Schema::create('ceac', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('sp_groupings', 255);
		// 	$table->integer('sp_id');
		// 	$table->string('sp_title', 255);
		// 	$table->string('sp_category', 255);
		// 	$table->string('sp_province', 255);
		// 	$table->string('sp_municipality', 255);
		// 	$table->string('sp_brgy', 255);
		// 	$table->datetime('municipal_orientation');
		// 	$table->datetime('social_investagation');
		// 	$table->datetime('first_ba');
		// 	$table->datetime('psa_workshop');
		// 	$table->datetime('second_ba');
		// 	$table->datetime('psa_action_plan');
		// 	$table->datetime('criteria_setting_workshop');
		// 	$table->datetime('project_dev_workshop');
		// 	$table->datetime('third_ba');
		// 	$table->datetime('project_proposal');
		// 	$table->datetime('miac_tech_review');
		// 	$table->datetime('fourth_ba');
		// 	$table->datetime('mdc_mtg_intergration');
		// 	$table->datetime('fifth_ba');
		// 	$table->datetime('capacity_building');
		// 	$table->datetime('formation_community');
		// 	$table->datetime('accountability_reporting');
		// 	$table->datetime('sustainability_evaluation');
		// 	$table->string('remarks', 1000);
		// });
	}

	public function down()
	{
		Schema::drop('ceac');
	}
}