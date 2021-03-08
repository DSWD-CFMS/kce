<?php

namespace App\Http\Controllers;
include("../vendor/autoload.php");

use Illuminate\Http\Request;
/* for Socket */
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
/* for Socket */

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use DateTime;
use Carbon\Carbon;

use App\Sp;
use App\Sp_logs_latest;
use App\Sp_pmr;
use App\Sp_pmr_logs;
use App\Sp_pmr_remarks_logs;
use App\Sp_logs;
use App\Sp_batch;
use App\Sp_cycle;
use App\Sp_type;
use App\Sp_groupings;
use App\Sp_category;
use App\Assigned_sp;
use App\Assigned_grouping;
use App\Files;
use App\Cadt;
use App\Users;
use App\CMFS_kalahi_2020_NCDDP_SP;
use App\CMFS_kalahi_2020_BUB_SP;
use App\CMFS_kalahi_2019_NCDDP_SP;
use App\CMFS_kalahi_2019_BUB_SP;
use App\CMFS_kalahi_2018_NCDDP_SP;
use App\CMFS_kalahi_2018_BUB_SP;
use App\CMFS_kalahi_2017_NCDDP_SP;
use App\CMFS_kalahi_2017_BUB_SP;
use App\CMFS_kalahi_2016_NCDDP_SP;
use App\CMFS_kalahi_2016_BUB_SP;
use App\CMFS_kalahi_2015_NCDDP_SP;
use App\CMFS_kalahi_2015_BUB_SP;

use App\CMFS_kalahi_2015_BUB_RFR;
use App\CMFS_kalahi_2015_NCDDP_RFR;
use App\CMFS_kalahi_2016_BUB_RFR;
use App\CMFS_kalahi_2016_NCDDP_RFR;
use App\CMFS_kalahi_2017_BUB_RFR;
use App\CMFS_kalahi_2017_NCDDP_RFR;
use App\CMFS_kalahi_2018_BUB_RFR;
use App\CMFS_kalahi_2018_NCDDP_RFR;
use App\CMFS_kalahi_2019_NCDDP_RFR;
use App\CMFS_kalahi_2019_BUB_RFR;
use App\CMFS_kalahi_2020_BUB_RFR;
use App\CMFS_kalahi_2020_NCDDP_RFR;

class Welcome_Controller extends Controller
{
    public function download(Request $rq){
        $path = Files::select('path')->where('id', $rq->path)->get();
        // return $path;
        return Storage::disk("public")->download($path[0]->path);
    }

    public function Initial_sp_data(Request $rq){
        $Initial_sp_data = new Initial_sp_data;
        $Initial_sp_data->setConnection('mysql3');
        $Initial_sp_data = $Initial_sp_data->get();
        return $Initial_sp_data;
    }

    public function get_modalities_sp(Request $rq){
        return Sp::with(['Sp_logs' => function($query){
            $query->whereNotNull('sp_logs_actual')->get();
            // $query->where('sp_logs_actual',null)->limit(1)->get();
        }])->with('Sp_category')
        ->with('Sp_cycle')
        ->with('Sp_batch')
        ->with('Sp_type')
        ->with('Sp_groupings')
        // ->with('Assigned_grouping')
        ->with(['Assigned_grouping' => function($query1){
            $query1->with(['Users' => function($query){
                $query->get();
            }])->get();
        }])
        ->with(['Assigned_sp' => function($query1){
            $query1->with(['Users' => function($query){
                $query->select('id','Fname','Lname')->get();
            }])->get();
        }])
        ->with('CMFS_kalahi_2015_BUB_SP')
        ->with('CMFS_kalahi_2016_BUB_SP')
        ->with('CMFS_kalahi_2017_BUB_SP')
        ->with('CMFS_kalahi_2018_BUB_SP')
        ->with('CMFS_kalahi_2020_BUB_SP')
        ->with('CMFS_kalahi_2015_BUB_RFR')
        ->with('CMFS_kalahi_2016_BUB_RFR')
        ->with('CMFS_kalahi_2017_BUB_RFR')
        ->with('CMFS_kalahi_2018_BUB_RFR')
        ->with('CMFS_kalahi_2020_BUB_RFR')
        ->with('CMFS_kalahi_2015_NCDDP_SP')
        ->with('CMFS_kalahi_2016_NCDDP_SP')
        ->with('CMFS_kalahi_2017_NCDDP_SP')
        ->with('CMFS_kalahi_2018_NCDDP_SP')
        ->with('CMFS_kalahi_2019_NCDDP_SP')
        ->with('CMFS_kalahi_2020_NCDDP_SP')
        ->with('CMFS_kalahi_2015_NCDDP_RFR')
        ->with('CMFS_kalahi_2016_NCDDP_RFR')
        ->with('CMFS_kalahi_2017_NCDDP_RFR')
        ->with('CMFS_kalahi_2018_NCDDP_RFR')
        ->with('CMFS_kalahi_2019_NCDDP_RFR')
        ->with('CMFS_kalahi_2020_NCDDP_RFR')
        ->whereIn('sp_implementation', [2018,2020])
        ->where('sp_status', 'On-going')
        ->Orwhere('sp_status', 'NYS')
        // ->orWhere('sp_status', 'Waved')
        // ->orWhere('sp_status', 'Transfered')
        ->get();
    }

    public function show_summary(){
        ob_start('ob_gzhandler');

        $data = Sp::with(['Sp_logs' => function($query){
           $query->select('sp_id','sp_logs_actual')->where('sp_logs_actual','<>',null)->get();
        }])
        ->where('sp_status','On-going')
        ->get()
        ->groupBy('sp_groupings');

        if(isset($data[3])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[3] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_ncddp_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_ncddp_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_ncddp_percentage = round($actual_weighted,2);
        }else{
            $weighted_ncddp_percentage = 0;
            array_push($return_data, $weighted_ncddp_percentage);
        };

        if(isset($data[4])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            // ->with('Assigned_grouping')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            // ->orWhere('sp_id',2018030002)
            // ->orWhere('sp_id',2018030040)
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[4] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            // ->with('Sp.Assigned_grouping')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);
            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_ipccdd_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_ipccdd_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_ipccdd_percentage = round($actual_weighted,2);
        }else{ 
            $weighted_ipccdd_percentage = 0;
            array_push($return_data, $weighted_ipccdd_percentage);
        };
     

        $target_ncddp = Sp::with('Sp_logs')
            ->where('sp_implementation',2020)
            ->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
            ->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
            ->where('sp_target_date_of_completion','<>', '')
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->where('sp_groupings',3)
            ->get()
            ->groupBy(function($d) {
                return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
            })->map(function($users) {
                return [$users->count()];
            });

        $actual_ncddp = Sp::with('Sp_logs')
            ->where('sp_implementation',2020)
            ->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
            ->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
            ->where('sp_target_date_of_completion','<>', '')
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->where('sp_groupings',3)
            ->get()
            ->groupBy(function($d) {
                return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
            })->map(function($users) {
                return [$users->count()];
            });

        $target_ipcdd = Sp::with('Sp_logs')
            ->where('sp_implementation',2020)
            ->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
            ->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
            ->where('sp_target_date_of_completion','<>', '')
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->whereIn('sp_groupings',[4])
            // ->orWhere('sp_id',2018030002)
            // ->orWhere('sp_id',2018030040)
            ->get()
            ->groupBy(function($d) {
                return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
            })->map(function($users) {
                return [$users->count()];
            });

        $actual_ipcdd = Sp::with('Sp_logs')
            ->where('sp_implementation',2020)
            ->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
            ->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
            ->where('sp_target_date_of_completion','<>', '')
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->whereIn('sp_groupings',[4])
            // ->orWhere('sp_id',2018030002)
            // ->orWhere('sp_id',2018030040)
            ->get()
            ->groupBy(function($d) {
                return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
            })->map(function($users) {
                return [$users->count()];
            });

        $group_per_muni_ncddp = Sp::where('sp_implementation',2020)
        ->where('sp_groupings',3)
        ->whereIn('sp_status',['NYS','On-going','Completed'])
        ->get()
        ->groupBy('sp_municipality');

        // return $group_per_muni_ncddp;

        $group_per_muni_ipccd = Sp::where('sp_implementation',2020)
        ->where('sp_groupings',4)
        ->whereIn('sp_status',['NYS','On-going','Completed'])
        // ->orWhere('sp_id',2018030002)
        // ->orWhere('sp_id',2018030040)
        ->get()
        ->groupBy('sp_municipality');

        $ncddp_per_cb = Sp::where('sp_implementation',2020)
        ->where('sp_groupings',3)
        ->whereIn('sp_status',['NYS','On-going','Completed'])
        ->get()
        ->groupBy('sp_cycle');

        $ipcdd_per_cadt = Sp::join('cadt', 'sp.sp_id', '=', 'cadt.sp_id')
        ->where('sp_groupings',4)
        ->where('sp_implementation',2020)
        // ->orWhere('sp.sp_id',2018030002)
        // ->orWhere('sp.sp_id',2018030040)
        ->whereIn('sp_status',['NYS','On-going','Completed'])
        ->get()
        ->groupBy(['sp_cycle','sp_batch']);

        // Pending: Get all weighted % sa tanan modality
        $return_data = [];
        $data = Sp::with(['Sp_logs' => function($query){
           $query->select('sp_id','sp_logs_actual')->where('sp_logs_actual','<>',null)->get();
        }])
        ->where('sp_status','On-going')
        ->get()
        ->groupBy('sp_groupings');

        // Weighted Percentage
        if (isset($data[1])){
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[1] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_kkb_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_kkb_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_kkb_percentage = round($actual_weighted,2);
        }else{
            $weighted_kkb_percentage = 0;
            array_push($return_data, $weighted_kkb_percentage);
        };

        if(isset($data[2])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[2] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_makilahok_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_makilahok_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_makilahok_percentage = round($actual_weighted,2);
        }else{
            $weighted_makilahok_percentage = 0;
            array_push($return_data, $weighted_makilahok_percentage);
        };

        if(isset($data[3])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[3] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_ncddp_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_ncddp_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_ncddp_percentage = round($actual_weighted,2);
        }else{
            $weighted_ncddp_percentage = 0;
            array_push($return_data, $weighted_ncddp_percentage);
        };

        if(isset($data[4])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            // ->with('Assigned_grouping')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            // ->orWhere('sp_id',2018030002)
            // ->orWhere('sp_id',2018030040)
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[4] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            // ->with('Sp.Assigned_grouping')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);
            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_ipccdd_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_ipccdd_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_ipccdd_percentage = round($actual_weighted,2);
        }else{ 
            $weighted_ipccdd_percentage = 0;
            array_push($return_data, $weighted_ipccdd_percentage);
        };

        if(isset($data[5])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[5] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
                $weighted_LandE_percentage = round($actual_weighted,2);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
                $weighted_LandE_percentage = round($actual_weighted,2);
            }

            // $actual_weighted = (array_sum($c) / $sp_cost);
            // $weighted_LandE_percentage = round($actual_weighted,2);
        }else{
            $weighted_LandE_percentage = 0;
            array_push($return_data, $weighted_LandE_percentage);
        };

        if(isset($data[6])) {
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_implementation', 2020)
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            foreach ($all_sp_data[6] as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')
            ->whereIn('sp_id',$sp_id)
            ->whereNotNull('sp_logs_actual')
            ->get()
            ->groupBy('sp_id');

            $sp_cost_data = [];
            foreach ($ddd as $key) {
                foreach ($key as $xx) {
                    array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                }
            }
            $sp_cost_data =  array_values(array_unique($sp_cost_data));
            $sp_cost = array_sum($sp_cost_data);

            // Actual Percentage
            $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

            $collected_sp_logs_data = collect($sp_logs_data);

            $per_spid = [];
            $per_spid_per_actual = [];
            $actual_percentage;
            foreach ($collected_sp_logs_data as $key) {
                array_push($per_spid, $key->last());
            }
            foreach ($per_spid as $key) {
                array_push($per_spid_per_actual, (float)$key->sp_logs_actual);
            }
            $actual_percentage = array_sum($per_spid_per_actual);

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            $actual_weighted = (array_sum($c) / $sp_cost);
            $weighted_ccl_percentage = round($actual_weighted,2);
        }else{
            $weighted_ccl_percentage = 0;
            array_push($return_data, $weighted_ccl_percentage);
        };

        
        return [
            $target_ncddp,
            $actual_ncddp,
            $target_ipcdd,
            $actual_ipcdd,
            $group_per_muni_ipccd,
            $group_per_muni_ncddp,
            $ncddp_per_cb,
            $ipcdd_per_cadt,
            $weighted_kkb_percentage,
            $weighted_makilahok_percentage,
            $weighted_ncddp_percentage,
            $weighted_ipccdd_percentage,
            $weighted_ccl_percentage,
            $weighted_LandE_percentage
        ];

        ob_end_flush();
    }

    public function show_summary_percentages(Request $rq){
        ob_start('ob_gzhandler');

        if($rq->type == 0){
            return Sp::with(['Assigned_grouping' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->get();
                }])->get();
            }])
            ->with(['Assigned_sp' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->select('id','Fname','Lname')->get();
                }])->get();
            }])
            ->with(['SpLogsLatest' => function($e){
               $e->whereNotNull('sp_logs_actual')->latest('updated_at');
            }])
            ->with('Sp_category')
            ->with('Sp_cycle')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_groupings')
            ->with('CMFS_kalahi_2015_BUB_SP')
            ->with('CMFS_kalahi_2016_BUB_SP')
            ->with('CMFS_kalahi_2017_BUB_SP')
            ->with('CMFS_kalahi_2018_BUB_SP')
            ->with('CMFS_kalahi_2020_BUB_SP')
            ->with('CMFS_kalahi_2015_BUB_RFR')
            ->with('CMFS_kalahi_2016_BUB_RFR')
            ->with('CMFS_kalahi_2017_BUB_RFR')
            ->with('CMFS_kalahi_2018_BUB_RFR')
            ->with('CMFS_kalahi_2020_BUB_RFR')
            ->with('CMFS_kalahi_2015_NCDDP_SP')
            ->with('CMFS_kalahi_2016_NCDDP_SP')
            ->with('CMFS_kalahi_2017_NCDDP_SP')
            ->with('CMFS_kalahi_2018_NCDDP_SP')
            ->with('CMFS_kalahi_2019_NCDDP_SP')
            ->with('CMFS_kalahi_2020_NCDDP_SP')
            ->with('CMFS_kalahi_2015_NCDDP_RFR')
            ->with('CMFS_kalahi_2016_NCDDP_RFR')
            ->with('CMFS_kalahi_2017_NCDDP_RFR')
            ->with('CMFS_kalahi_2018_NCDDP_RFR')
            ->with('CMFS_kalahi_2019_NCDDP_RFR')
            ->with('CMFS_kalahi_2020_NCDDP_RFR')
            ->where('sp_groupings',$rq->modality)
            ->whereNull('actual')
            ->where('sp_implementation',2020)
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->get();

        }else if($rq->type == 1){
            $arr = [0.01,59.99];
            return Sp::with(['Assigned_grouping' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->get();
                }])->get();
            }])
            ->with(['SpLogsLatest' => function($e){
               $e->whereNotNull('sp_logs_actual')->latest('updated_at');
            }])
            ->with('Sp_category')
            ->with('Sp_cycle')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_groupings')
            ->with('CMFS_kalahi_2015_BUB_SP')
            ->with('CMFS_kalahi_2016_BUB_SP')
            ->with('CMFS_kalahi_2017_BUB_SP')
            ->with('CMFS_kalahi_2018_BUB_SP')
            ->with('CMFS_kalahi_2020_BUB_SP')
            ->with('CMFS_kalahi_2015_BUB_RFR')
            ->with('CMFS_kalahi_2016_BUB_RFR')
            ->with('CMFS_kalahi_2017_BUB_RFR')
            ->with('CMFS_kalahi_2018_BUB_RFR')
            ->with('CMFS_kalahi_2020_BUB_RFR')
            ->with('CMFS_kalahi_2015_NCDDP_SP')
            ->with('CMFS_kalahi_2016_NCDDP_SP')
            ->with('CMFS_kalahi_2017_NCDDP_SP')
            ->with('CMFS_kalahi_2018_NCDDP_SP')
            ->with('CMFS_kalahi_2019_NCDDP_SP')
            ->with('CMFS_kalahi_2020_NCDDP_SP')
            ->with('CMFS_kalahi_2015_NCDDP_RFR')
            ->with('CMFS_kalahi_2016_NCDDP_RFR')
            ->with('CMFS_kalahi_2017_NCDDP_RFR')
            ->with('CMFS_kalahi_2018_NCDDP_RFR')
            ->with('CMFS_kalahi_2019_NCDDP_RFR')
            ->with('CMFS_kalahi_2020_NCDDP_RFR')
            ->with(['Assigned_sp' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->select('id','Fname','Lname')->get();
                }])->get();
            }])
            ->where('sp_groupings',$rq->modality)
            ->whereBetween('actual', $arr)
            ->where('sp_implementation',2020)
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->get();

        }else if($rq->type == 2){
            $arr = [60.00,99.99];
            return Sp::with(['Assigned_grouping' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->get();
                }])->get();
            }])
            ->with(['Assigned_sp' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->select('id','Fname','Lname')->get();
                }])->get();
            }])
            ->with(['SpLogsLatest' => function($e){
               $e->whereNotNull('sp_logs_actual')->latest('updated_at');
            }])
            ->with('Sp_category')
            ->with('Sp_cycle')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_groupings')
            ->with('CMFS_kalahi_2015_BUB_SP')
            ->with('CMFS_kalahi_2016_BUB_SP')
            ->with('CMFS_kalahi_2017_BUB_SP')
            ->with('CMFS_kalahi_2018_BUB_SP')
            ->with('CMFS_kalahi_2020_BUB_SP')
            ->with('CMFS_kalahi_2015_BUB_RFR')
            ->with('CMFS_kalahi_2016_BUB_RFR')
            ->with('CMFS_kalahi_2017_BUB_RFR')
            ->with('CMFS_kalahi_2018_BUB_RFR')
            ->with('CMFS_kalahi_2020_BUB_RFR')
            ->with('CMFS_kalahi_2015_NCDDP_SP')
            ->with('CMFS_kalahi_2016_NCDDP_SP')
            ->with('CMFS_kalahi_2017_NCDDP_SP')
            ->with('CMFS_kalahi_2018_NCDDP_SP')
            ->with('CMFS_kalahi_2019_NCDDP_SP')
            ->with('CMFS_kalahi_2020_NCDDP_SP')
            ->with('CMFS_kalahi_2015_NCDDP_RFR')
            ->with('CMFS_kalahi_2016_NCDDP_RFR')
            ->with('CMFS_kalahi_2017_NCDDP_RFR')
            ->with('CMFS_kalahi_2018_NCDDP_RFR')
            ->with('CMFS_kalahi_2019_NCDDP_RFR')
            ->with('CMFS_kalahi_2020_NCDDP_RFR')
            ->where('sp_groupings',$rq->modality)
            ->whereBetween('actual', $arr)
            ->where('sp_implementation',2020)
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->get();

        }else if($rq->type == 3){
            return Sp::with(['Assigned_grouping' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->get();
                }])->get();
            }])
            ->with(['Assigned_sp' => function($query1){
                $query1->with(['Users' => function($query){
                    $query->select('id','Fname','Lname')->get();
                }])->get();
            }])
            ->with(['SpLogsLatest' => function($e){
               $e->whereNotNull('sp_logs_actual')->latest('updated_at');
            }])
            ->with('Sp_category')
            ->with('Sp_cycle')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_groupings')
            ->with('CMFS_kalahi_2015_BUB_SP')
            ->with('CMFS_kalahi_2016_BUB_SP')
            ->with('CMFS_kalahi_2017_BUB_SP')
            ->with('CMFS_kalahi_2018_BUB_SP')
            ->with('CMFS_kalahi_2020_BUB_SP')
            ->with('CMFS_kalahi_2015_BUB_RFR')
            ->with('CMFS_kalahi_2016_BUB_RFR')
            ->with('CMFS_kalahi_2017_BUB_RFR')
            ->with('CMFS_kalahi_2018_BUB_RFR')
            ->with('CMFS_kalahi_2020_BUB_RFR')
            ->with('CMFS_kalahi_2015_NCDDP_SP')
            ->with('CMFS_kalahi_2016_NCDDP_SP')
            ->with('CMFS_kalahi_2017_NCDDP_SP')
            ->with('CMFS_kalahi_2018_NCDDP_SP')
            ->with('CMFS_kalahi_2019_NCDDP_SP')
            ->with('CMFS_kalahi_2020_NCDDP_SP')
            ->with('CMFS_kalahi_2015_NCDDP_RFR')
            ->with('CMFS_kalahi_2016_NCDDP_RFR')
            ->with('CMFS_kalahi_2017_NCDDP_RFR')
            ->with('CMFS_kalahi_2018_NCDDP_RFR')
            ->with('CMFS_kalahi_2019_NCDDP_RFR')
            ->with('CMFS_kalahi_2020_NCDDP_RFR')
            ->where('sp_groupings',$rq->modality)
            ->where('actual',100.00)
            ->where('sp_implementation',2020)
            ->whereIn('sp_status',['NYS','On-going','Completed'])
            ->get();
        }else;

        // return Sp::where('sp_groupings',$rq->modality)
        // ->whereBetween('actual',$arr)
        // ->where('sp_implementation',2020)
        // ->whereIn('sp_status',['NYS','On-going','Completed'])
        // ->get();
        
        ob_end_flush();
    }

}
