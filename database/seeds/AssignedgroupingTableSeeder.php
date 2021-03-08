<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Assigned_grouping;

class AssignedgroupingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assigned_grouping::insert([
    		'sp_grouping_id'=>'1',
			'assigned_to'=>'2',
        ]);

        Assigned_grouping::insert([
    		'sp_grouping_id'=>'3',
			'assigned_to'=>'2',
        ]);


        Assigned_grouping::insert([
    		'sp_grouping_id'=>'3',
			'assigned_to'=>'2',
        ]);
    }
}
