<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sp;

class SpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sp::insert([
            'sp_groupings'=>'1',
            'sp_title'=>'ABALONE, SPINY ROCK OYSTER AQUACULTURE AND BANGUS PRODUCTION',
            'sp_id'=>'2018040003',
            'sp_category'=>'3',
            'sp_province'=>'SURIGAO DEL SUR',
            'sp_municipality'=>'BAROBO',
            'sp_brgy'=>'CABACUNGAN',
            'sp_physical_target'=>'1.00 lot',
            'sp_project_cost'=>'1518260.00',
            'sp_rfr_first_tranche_date'=>'2019-10-27',
            'sp_date_started'=>'2019-10-29',
            'sp_estimated_duration'=>'75',
            'sp_target_date_of_completion'=>'2020-01-11',
            'sp_days_suspended'=>'',
            'sp_actual_date_completed'=>'2020-01-1',
            'sp_date_of_turnover'=>'2020-01-20',
            'sp_cycle'=>'1',
            'sp_batch'=>'1',
            'sp_type'=>'29',
        ]);

        Sp::insert([
            'sp_groupings'=>'3',
            'sp_title'=>'CONSTRUCTION OF ONE UNIT TWO CLASSROOM SCHOOL BUILDING',
            'sp_id'=>'29739',
            'sp_category'=>'1',
            'sp_province'=>'AGUSAN DEL SUR',
            'sp_municipality'=>'PROSPERIDAD',
            'sp_brgy'=>'MABUHAY',
            'sp_physical_target'=>'126 Sq.m.',
            'sp_project_cost'=>'3010000.00',
            'sp_rfr_first_tranche_date'=>'2019-07-05',
            'sp_date_started'=>'2019-07-08',
            'sp_estimated_duration'=>'120',
            'sp_target_date_of_completion'=>'2019-11-04',
            'sp_days_suspended'=>'',
            'sp_actual_date_completed'=>'2019-10-17',
            'sp_date_of_turnover'=>'2019-11-20',
            'sp_cycle'=>'3',
            'sp_batch'=>'2',
            'sp_type'=>'12',
        ]);

        Sp::insert([
            'sp_groupings'=>'3',
            'sp_title'=>'CONSTRUCTION OF BARANGAY HEALTH STATION',
            'sp_id'=>'29737',
            'sp_category'=>'1',
            'sp_province'=>'AGUSAN DEL SUR',
            'sp_municipality'=>'PROSPERIDAD',
            'sp_brgy'=>'AWA',
            'sp_physical_target'=>'52.26 SQ.M.',
            'sp_project_cost'=>'2140000.00',
            'sp_rfr_first_tranche_date'=>'2019-07-05',
            'sp_date_started'=>'2019-07-10',
            'sp_estimated_duration'=>'90',
            'sp_target_date_of_completion'=>'2019-10-07',
            'sp_days_suspended'=>'',
            'sp_actual_date_completed'=>'2019-10-31',
            'sp_date_of_turnover'=>'2019-11-20',
            'sp_fullblown_proposal'=>'1',
            'sp_cycle'=>'3',
            'sp_batch'=>'2',
            'sp_type'=>'3',
        ]);
    }
}
