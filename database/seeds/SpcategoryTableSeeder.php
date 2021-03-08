<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sp_category;

class SpcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	// kkb
        Sp_category::insert([
            'category' => 'PUBLIC GOODS'
        ]);

        Sp_category::insert([
            'category' => 'ENVIRONMENTAL PROTECTION AND CONSERVATION'
        ]);

        Sp_category::insert([
            'category' => 'ENTERPRISE'
        ]);
    }
}
