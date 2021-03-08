<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sp_batch;

class SpbatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sp_batch::insert([
    		'batch'=>'1',
        ]);

        Sp_batch::insert([
    		'batch'=>'2',
        ]);

        Sp_batch::insert([
    		'batch'=>'3',
        ]);

        Sp_batch::insert([
    		'batch'=>'4',
        ]);

        Sp_batch::insert([
    		'batch'=>'5',
        ]);
    }
}
