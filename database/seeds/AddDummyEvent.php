<?php

use Illuminate\Database\Seeder;
use App\Whereabouts;

class AddDummyEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$data = [

        	['title'=>'Travel 1', 'description'=>'Travel Event 1', 'location'=>'Hinatuan, SDS', 'start_date'=>'2019-10-10', 'end_date'=>'2019-10-15', 'user_id'=>'1' ],

        	['title'=>'Travel 2', 'description'=>'Travel Event 2', 'location'=>'San Francisco, ADS', 'start_date'=>'2019-10-11', 'end_date'=>'2019-10-16', 'user_id'=>'2' ],

        	['title'=>'Travel 1', 'description'=>'Travel Event 3', 'location'=>'Prosperidad, ADS', 'start_date'=>'2019-10-16', 'end_date'=>'2019-10-22', 'user_id'=>'2' ],

        ];
        foreach ($data as $key => $value) {

        	Whereabouts::create($value);
        }
    }
}
