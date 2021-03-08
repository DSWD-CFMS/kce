<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sp_cycle;

class SpcycleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sp_cycle::insert([
    		'cycle'=>'1',
        ]);

        Sp_cycle::insert([
    		'cycle'=>'2',
        ]);

        Sp_cycle::insert([
    		'cycle'=>'3',
        ]);

        Sp_cycle::insert([
    		'cycle'=>'4',
        ]);

        Sp_cycle::insert([
    		'cycle'=>'5',
        ]);
    }
}
