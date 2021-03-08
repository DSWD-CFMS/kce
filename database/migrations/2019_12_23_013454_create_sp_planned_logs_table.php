<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpPlannedLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sp_planned_logs', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->timestamps();
        //     $table->string('sp_id');
        //     $table->double('planned', 8, 2);
        // });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_planned_logs');
    }
}
