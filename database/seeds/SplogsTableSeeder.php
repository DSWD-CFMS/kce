<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sp_logs;

class SplogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sp_logs::insert([
    		'sp_id'=>'2018040003',
        	'sp_logs_planned'=>'91.07',
        	'sp_logs_actual'=>'96.00',
        	'sp_logs_slippage'=>'3.93',
    		'sp_logs_variation_order'=>'',
        	'sp_logs_spcr'=>'',
        	'sp_logs_issues'=>'',
        	'sp_logs_analysis'=>'Almost done',
        	'sp_logs_remarks'=>'',
        	'sp_logs_esmr'=>'',
        	'sp_logs_csr'=>'',
        	'sp_logs_last_user_update'=>''
        ]);

        Sp_logs::insert([
        		'sp_id'=>'29739',
	        	'sp_logs_planned'=>'91.07',
	        	'sp_logs_actual'=>'96.00',
	        	'sp_logs_slippage'=>'3.93',
	        	'sp_logs_variation_order'=>'',
	        	'sp_logs_spcr'=>'',
	        	'sp_logs_issues'=>'',
	        	'sp_logs_analysis'=>'Almost done',
	        	'sp_logs_remarks'=>'',
	        	'sp_logs_esmr'=>'',
	        	'sp_logs_csr'=>'',
	        	'sp_logs_last_user_update'=>''
        ]);

        Sp_logs::insert([
        		'sp_id'=>'29737',
	        	'sp_logs_planned'=>'91.07',
	        	'sp_logs_actual'=>'96.00',
	        	'sp_logs_slippage'=>'3.93',
	        	'sp_logs_variation_order'=>'',
	        	'sp_logs_spcr'=>'',
	        	'sp_logs_issues'=>'',
	        	'sp_logs_analysis'=>'Almost done',
	        	'sp_logs_remarks'=>'',
	        	'sp_logs_esmr'=>'',
	        	'sp_logs_csr'=>'',
	        	'sp_logs_last_user_update'=>''
        ]);




        Sp_logs::insert([
        		'sp_id'=>'2018040003',
	        	'sp_logs_planned'=>'96.07',
	        	'sp_logs_actual'=>'100.00',
	        	'sp_logs_slippage'=>'3.93',
	        	'sp_logs_variation_order'=>'',
	        	'sp_logs_spcr'=>'',
	        	'sp_logs_issues'=>'',
	        	'sp_logs_analysis'=>'Completed',
	        	'sp_logs_remarks'=>'',
	        	'sp_logs_esmr'=>'',
	        	'sp_logs_csr'=>'',
	        	'sp_logs_last_user_update'=>''
        ]);


        Sp_logs::insert([
        		'sp_id'=>'29739',
	        	'sp_logs_planned'=>'96.07',
	        	'sp_logs_actual'=>'100.00',
	        	'sp_logs_slippage'=>'3.93',
	        	'sp_logs_variation_order'=>'',
	        	'sp_logs_spcr'=>'',
	        	'sp_logs_issues'=>'',
	        	'sp_logs_analysis'=>'Completed',
	        	'sp_logs_remarks'=>'',
	        	'sp_logs_esmr'=>'',
	        	'sp_logs_csr'=>'',
	        	'sp_logs_last_user_update'=>''
        ]);

        Sp_logs::insert([
        		'sp_id'=>'29737',
	        	'sp_logs_planned'=>'96.07',
	        	'sp_logs_actual'=>'100.00',
	        	'sp_logs_slippage'=>'3.93',
	        	'sp_logs_variation_order'=>'',
	        	'sp_logs_spcr'=>'',
	        	'sp_logs_issues'=>'',
	        	'sp_logs_analysis'=>'Completed',
	        	'sp_logs_remarks'=>'',
	        	'sp_logs_esmr'=>'',
	        	'sp_logs_csr'=>'',
	        	'sp_logs_last_user_update'=>''
        ]);
    }
}
