<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Assigned_sp;

class AssignedspTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assigned_sp::insert([
    		'sp_id'=>'2018040003',
			'assigned_to'=>'3',
        ]);

        Assigned_sp::insert([
    		'sp_id'=>'29739',
			'assigned_to'=>'3',
        ]);


        Assigned_sp::insert([
    		'sp_id'=>'29737',
			'assigned_to'=>'3',
        ]);
    }
}
