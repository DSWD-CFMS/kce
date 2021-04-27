<?php

namespace App\Http\Controllers;

include("../vendor/autoload.php");

use Illuminate\Http\Request;
/* for Socket */
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
/* for Socket */
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use DateTime;

use App\Sp;
use App\Sp_logs;
use App\Sp_batch;
use App\Sp_cycle;
use App\Sp_type;
use App\Sp_groupings;
use App\Sp_category;
use App\Assigned_sp;
use App\Assigned_grouping;
use App\Files;
use App\Users;
use App\Cadt;
use App\CMFS_kalahi_2021_NCDDP_SP;
use App\CMFS_kalahi_2021_BUB_SP;
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
use App\CMFS_kalahi_2021_BUB_RFR;
use App\CMFS_kalahi_2021_NCDDP_RFR;

class ADMIN_Controller extends Controller
{
    public function index(){
        return view('user_admin.home');
    }

    public function fetch_my_data(Request $rq){
        ob_start('ob_gzhandler');
        // Latest SP
        // On-going, NYS, Completed

        // Pending: Get all weighted % sa tanan modality
        $return_data = [];
        $data = Sp::with(['Sp_logs' => function($query){
           $query->select('sp_id','sp_logs_actual')->where('sp_logs_actual','<>',null)->get();
        }])
        ->where('sp_status','On-going')
        ->get()
        ->groupBy('sp_groupings');
 
        $latest_sp = Sp::with(['Sp_logs' => function($query){
            $query->get();
           // $query->select('sp_id','sp_logs_actual')->where('sp_logs_actual','<>',null)->get();
        }])
        ->with('Sp_pmr.Sp_pmr_logs')
        ->with('Assigned_sp.Users')
        ->with('Sp_groupings.Assigned_grouping.Users')
        ->with('Sp_groupings')
        ->where('sp_status','On-going')
        ->latest('updated_at')
        ->first();

        $sp_logs = Sp::with(['Sp_logs' => function($query){
           $query->where('sp_logs_actual','<>',null)->get();
        }])
        ->where('sp_status','On-going')
        ->latest('updated_at')
        ->first();

        // Weighted Percentage
        if (isset($data[1])){
            $all_sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->get();
            }])
            ->whereIn('sp_implementation', [2020,2021])
            ->whereIn('sp_status',['Completed','On-going'])
            ->get()->groupBy('sp_groupings');

            $sp_id = [];
            //BORN EDIT
            if ( ! isset($all_sp_data[1])) {
               $all_sp_data[1] = null;
            }else{
                foreach ($all_sp_data[1] as $key) {
                    array_push($sp_id, $key->sp_id);
                }
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
            ->whereIn('sp_implementation', [2020,2021])
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
            ->whereIn('sp_implementation', [2020,2021])
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
            ->whereIn('sp_implementation', [2020,2021])
            ->whereIn('sp_status',['Completed','On-going'])
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
            ->whereIn('sp_implementation', [2020,2021])
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
            ->whereIn('sp_implementation', [2020,2021])
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

        $Count_On_going_sp = Sp::where('sp_status','On-going')->get()->count();
        // All SP Groupings
        // $Count_Completed_sp = Sp::where('sp_status','Completed')->get()->count();
        // Walay CCL, L&E and MAKILAHOK SP Groupings
        $Count_Completed_sp = Sp::whereIn('sp_groupings',[3,4])->where('sp_status','Completed')->where('sp_implementation','2020')->get()->count();

        $tmp_Average_Est_Days_Completion = Sp::whereIn('sp_groupings',[3,4])->where('sp_status','Completed')->where('sp_implementation','2020')->get()->avg('sp_estimated_duration');

        $Average_Est_Days_Completion = round($tmp_Average_Est_Days_Completion,0);

        // ->where('sp_implementation','2019')->orWhere('sp_implementation','2020') 
        // ->where('sp_date_started','<>','0000-00-00 00:00:00')->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
        $sp = Sp::whereIn('sp_groupings',[3,4])->where('sp_status', 'Completed')->where('sp_implementation','2020')->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')->get();

        $arr = [];
        foreach ($sp as $key) {
            $date_1 = strtotime($key->sp_date_started);
            // date('Y-m-d',$key->sp_target_date_of_completion);

            $date_2 = strtotime($key->sp_actual_date_completed);
            // date('Y-m-d',$key->sp_actual_date_completed);

            // array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
            array_push($arr, (($date_2 - $date_1) / (60*60*24)));
        }

        if( array_sum($arr) == 0 || count($arr) == 0){
            $Average_Actual_Days_Completion = 'No data';
        }else{
            $Average_Actual_Days_Completion = round(array_sum($arr) / count($arr));
        }

        // NYS
        $nys = Sp::where('sp_implementation',2020)->where('sp_status', 'NYS')->get()->groupBy('sp_groupings');
        $ongoing = Sp::where('sp_implementation',2020)->where('sp_status', 'On-going')->get()->groupBy('sp_groupings');
        // $ongoing = Sp::where('sp_implementation',2020)->where('sp_status', 'On-going')->get()->groupBy('sp_groupings');
        $completed = Sp::where('sp_implementation',2020)->where('sp_status', 'Completed')->get()->groupBy('sp_groupings');
        
        // $user = Users::select('id','Fname','Lname', 'contact')->where('role','ADMIN')->where('id', Auth::User()->id)->get();
        return [
            $weighted_kkb_percentage,
            $weighted_makilahok_percentage,
            $weighted_ncddp_percentage,
            $weighted_ipccdd_percentage,
            $weighted_ccl_percentage,
            $weighted_LandE_percentage,
            $Count_On_going_sp,
            $Count_Completed_sp,
            $Average_Est_Days_Completion,
            $Average_Actual_Days_Completion,
            $latest_sp,
            $sp_logs,
            $nys,
            $ongoing,
            $completed
        ];
        ob_end_flush();
    }

    public function new_SP(Request $rq){
        ob_start('ob_gzhandler');
            $sp_cat = Sp_category::select('id','category')->get();
            $sp_type = Sp_type::select('id','type')->get();
            $dac = Users::select('id','Fname','Lname', 'contact')->where('role','DAC')->get();
            $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();

            return [$sp_cat,$sp_type,$dac,$rpmo];
        ob_end_flush();
    }

    // BORN UDPATE-----------------
    public function import_to_kce(Request $rq){
        // ob_start('ob_gzhandler');
            return $rq;
        //     $sp_cat = Sp_category::select('id','category')->get();
        //     $sp_type = Sp_type::select('id','type')->get();
        //     $dac = Users::select('id','Fname','Lname', 'contact')->where('role','DAC')->get();
        //     $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();

        //     return [$sp_cat,$sp_type,$dac,$rpmo];
        // ob_end_flush();
    }

    public function user_list(Request $rq){
        ob_start('ob_gzhandler');
	    	$users = Users::select('id','Fname','Lname','Mname','birthdate','contact','email','created_at','emp_id_no','assigned_grouping','role')
            ->with('Assigned_grouping.Sp_groupings')
            ->with('Sp_groupings')->get();

	    	return $users;
        ob_end_flush();
    }

    public function enroll_user(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {

                // return $rq;
				$addnew = new Users;
				$addnew->assigned_grouping = $rq->user_modality;
				$addnew->fname = $rq->fname;
				$addnew->mname = $rq->mname;
				$addnew->lname = $rq->lname;
				$addnew->emp_id_no = $rq->emp_id_no;
				$addnew->birthdate = $rq->bdate;
				$addnew->email = $rq->email;
				$addnew->contact = $rq->contact;
				$addnew->username = $rq->username;
				$addnew->password = Hash::make($rq->password);
				$addnew->role = $rq->user_role;
				$addnew->save();

                // return Hash::make($rq->password);
                // Make groupings
				DB::commit();

				return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
            	return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();
    }

    public function assign_add_modality(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                $addnew = new Assigned_grouping;
                $addnew->sp_grouping_id = $rq->modality;
                $addnew->assigned_to = $rq->id;
                $addnew->save();
                DB::commit();

                return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();


    }

    public function show_modality(){
        return view('user_admin.modality_list');
    }

    public function fetch_modality(Request $rq){
		ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                if($rq->modality == 1 || $rq->modality == 2 || $rq->modality == 4 || $rq->modality == 5 || $rq->modality == 6){

                    if($rq->year == 2015){
                        $CMFS_kalahi_2015_BUB_SP = CMFS_kalahi_2015_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2015_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2016){
                        $CMFS_kalahi_2016_BUB_SP = CMFS_kalahi_2016_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2016_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2017){
                        $CMFS_kalahi_2017_BUB_SP = CMFS_kalahi_2017_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2017_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2018){
                        $CMFS_kalahi_2018_BUB_SP = CMFS_kalahi_2018_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2018_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2019){
                        $CMFS_kalahi_2019_BUB_SP = CMFS_kalahi_2019_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2019_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2020){
                        $CMFS_kalahi_2020_BUB_SP = CMFS_kalahi_2020_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->where(['cancelled'=>0])->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2020_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2021){
                        $CMFS_kalahi_2021_BUB_SP = CMFS_kalahi_2021_BUB_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2021_BUB_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else;

                }else{

                    if($rq->year == 2014){
                        $CMFS_kalahi_2014_NCDDP_SP = CMFS_kalahi_2014_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2014_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2015){
                        $CMFS_kalahi_2015_NCDDP_SP = CMFS_kalahi_2015_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2015_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2016){
                        $CMFS_kalahi_2016_NCDDP_SP = CMFS_kalahi_2016_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2016_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2017){
                        $CMFS_kalahi_2017_NCDDP_SP = CMFS_kalahi_2017_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2017_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2018){
                        $CMFS_kalahi_2018_NCDDP_SP = CMFS_kalahi_2018_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2018_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2019){
                            $CMFS_kalahi_2019_NCDDP_SP = CMFS_kalahi_2019_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2019_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2020){
                        $CMFS_kalahi_2020_NCDDP_SP = CMFS_kalahi_2020_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2020_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else if($rq->year == 2021){
                        $CMFS_kalahi_2021_NCDDP_SP = CMFS_kalahi_2021_NCDDP_SP::with('sp.assigned_sp.users')->with('sp.sp_logs')->with('brgy.cities.provinces.region')->get();
                        $sp_cat = Sp_category::select('id','category')->get();
                        $sp_type = Sp_type::select('id','type')->get();
                        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
                        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();
                        return [$CMFS_kalahi_2021_NCDDP_SP,$sp_cat,$sp_type,$dac,$rpmo];
                    }else;

                    // $sp_per_modality = Sp::with('Sp_logs')
                    // ->with(['Assigned_grouping.Users' => function($query1){
                    //     $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
                    // }])
                    // ->with(['Assigned_sp.Users' => function($query){
                    //    // $query->select('Fname','Lname','emp_id_no','role','contact')->get();
                    //     $query->select('id','Fname','Lname','emp_id_no','contact','role')->get();
                    // }])
                    // ->where('sp_groupings',$rq->modality)->get();

                    // return $sp_per_modality;
                }

				DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
            	return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();
    }

    // Encoding of SP
    	// - Assign RPMO and DAC
    public function encode_SP(Request $rq){
    	// Insert sp
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                if($rq->whatmodality == 3){
                    $addnew = new Sp;
                    $addnew->sp_groupings = $rq->whatmodality;
                    $addnew->sp_id = $rq->sp_id;
                    $addnew->sp_title = $rq->sp_title;
                    $addnew->sp_category = $rq->sp_cat_data;
                    $addnew->sp_type = $rq->sp_typ_data;

                    $addnew->sp_province = $rq->brgy['cities']['provinces']['prov_name'];
                    $addnew->sp_municipality = $rq->brgy['cities']['city_name'];
                    $addnew->sp_brgy = $rq->brgy['brgy_name'];

                    $addnew->sp_project_cost = floatval($rq->grant) + floatval($rq->grant) + floatval($rq->lcc_blgu) + floatval($rq->lcc_blgu_ik) +  + floatval($rq->lcc_community) + floatval($rq->lcc_community_ik) + floatval($rq->lcc_in_kind) + floatval($rq->lcc_mlgu) + floatval($rq->lcc_mlgu_ik) + floatval($rq->lcc_others) + floatval($rq->lcc_others_ik) + floatval($rq->lcc_plgu) + floatval($rq->lcc_plgu_ik) + floatval($rq->other_amount);
                    // $addnew->sp_date_started = NULL;
                    // $addnew->sp_target_date_of_completion = NULL;
                    // $addnew->sp_actual_date_completed = NULL;
                    // $addnew->sp_date_of_turnover = NULL;
                    // $addnew->sp_estimated_duration = NULL;
                    // $addnew->sp_cycle = $rq->sp_cyle;
                    // $addnew->sp_batch = $rq->sp_batch;
                    $addnew->save();

                }else{

                    $addnew = new Sp;
                    $addnew->sp_groupings = $rq->whatmodality;
                    $addnew->sp_id = $rq->id;
                    $addnew->sp_title = $rq->sp_title;
                    $addnew->sp_category = $rq->sp_cat_data;
                    $addnew->sp_type = $rq->sp_typ_data;

                    $addnew->sp_province = $rq->brgy['cities']['provinces']['prov_name'];
                    $addnew->sp_municipality = $rq->brgy['cities']['city_name'];
                    $addnew->sp_brgy = $rq->brgy['brgy_name'];

                    $addnew->sp_project_cost = floatval($rq->grant) + floatval($rq->grant) + floatval($rq->lcc_blgu) + floatval($rq->lcc_blgu_ik) +  + floatval($rq->lcc_community) + floatval($rq->lcc_community_ik) + floatval($rq->lcc_in_kind) + floatval($rq->lcc_mlgu) + floatval($rq->lcc_mlgu_ik) + floatval($rq->lcc_others) + floatval($rq->lcc_others_ik) + floatval($rq->lcc_plgu) + floatval($rq->lcc_plgu_ik) + floatval($rq->other_amount);
                    $addnew->sp_cycle = $rq->sp_cyle;
                    $addnew->sp_batch = $rq->sp_batch;
                    $addnew->save();
                }

				// $new_assigned_grouping = new Assigned_grouping;
				// $new_assigned_grouping->sp_grouping_id = $rq->whatmodality;
				// $new_assigned_grouping->assigned_to = $rq->assigned_rpmo;
				// $new_assigned_grouping->save();

                if($rq->whatmodality == 3){
                    $new_assigned_sp = new Assigned_sp;
                    $new_assigned_sp->sp_id = $rq->sp_id;
                    $new_assigned_sp->assigned_grouping = $rq->whatmodality;
                    $new_assigned_sp->assigned_to = $rq->assigned_dac;
                    $new_assigned_sp->save();
                }else{
                    $new_assigned_sp = new Assigned_sp;
                    $new_assigned_sp->sp_id = $rq->id;
                    $new_assigned_sp->assigned_grouping = $rq->whatmodality;
                    $new_assigned_sp->assigned_to = $rq->assigned_dac;
                    $new_assigned_sp->save();
                }


                if($rq->sp_modality_type == 4){
                    $cadt = new Cadt;
                    $cadt->sp_id = $rq->sp_id_data;
                    $cadt->cadt_no = $rq->sp_cadt;
                    $cadt->save();
                }


				DB::commit();

				return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
            	return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();
    	// Insert assigned_sp
    	// Inesert assigned grouping
    }

    public function assign_SP(Request $rq){
        // Insert sp
        ob_start('ob_gzhandler');
            DB::beginTransaction();

            try {

                $new_assigned_sp = new Assigned_sp;
                $new_assigned_sp->sp_id = $rq->sp['sp_id'];
                $new_assigned_sp->assigned_grouping = $rq->sp['sp_groupings'];
                // $new_assigned_sp->assigned_grouping = $rq->whatmodality;
                $new_assigned_sp->assigned_to = $rq->assigned_dac;
                $new_assigned_sp->save();
                DB::commit();

                return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();
    }

    // Update an SP
    public function update_SP(Request $rq){

    }
    // Delete an SP
    public function delete_SP(Request $rq){

    }

    public function fetch_SP(Request $rq){
        ob_start('ob_gzhandler');

        $sp_cat = Sp_category::select('id','category')->get();
        $sp_type = Sp_type::select('id','type')->get();
        $dac = Users::select('id','Fname','Lname', 'contact')->whereNotIn('id',[13,14,15,16,17])->where('role','DAC')->get();
        $rpmo = Users::select('id','Fname','Lname', 'contact')->where('role','RPMO')->get();


            	if($rq->modality == 1){
            		return 'KKB';
            	}else if($rq->modality == 2){
            		return 'MAKILAHOK';
            	}else if($rq->modality == 3){
                    return 'NCDDP';
            	}else if($rq->modality == 4){
                    $CMFS_IPCDD_2020 = new CMFS_IPCDD_2020;
                    $CMFS_IPCDD_2020->setConnection('mysql3');
                    // Total Project Cost =  Grant + lcc_cash + lcc_in_kind
                    $multi = $CMFS_IPCDD_2020->select('id','brgy_code','sp_title','grant','lcc_cash','lcc_in_kind','cadt')->with('CMFS_brgy.CMFS_muni.CMFS_prov')->where('is_waived',0)->get();
                    return [$multi,$sp_cat,$sp_type,$dac,$rpmo];
            	}else if($rq->modality == 5){
            		return 'CCL';
            	}else if($rq->modality == 6){
            		return 'L&E';
            	}else;

        ob_end_flush();
    }


    public function delete_user(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {

                Users::where('id', $rq->user_id)->delete();

                DB::commit();

                return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return $e->getMessage();
            }
        ob_end_flush();
    }

    public function fetch_my_latest_file(Request $rq){
        ob_start('ob_gzhandler');
            $files = Files::where('origin',Auth::User()->id)->orderBy('id', 'desc')->take(3)->get();
            return $files;
        ob_end_flush();
    }

    public function fetch_my_all_file(Request $rq){
        ob_start('ob_gzhandler');
            $files = Files::where('origin',Auth::User()->id)->orderBy('id', 'desc')->get();
            return $files;
        ob_end_flush();
    }

    public function fetch_all_file(Request $rq){
        ob_start('ob_gzhandler');
            $files = Files::with(['Users' => function($query){
               $query->select('id','emp_id_no','Fname','Lname','role')->get();
            }])
            ->orderBy('id', 'desc')->get();
            return $files;
        ob_end_flush();
    }


    public function create_planned_logs(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                foreach ($rq->obj as $key) {
                    $update_sp = new Sp_logs;
                    $update_sp->sp_id = $rq->sp_id;
                    $update_sp->sp_logs_planned_target_date = $key['target_date'];
                    // $update_sp->sp_logs_planned_target_date = date("Y-m-d H:i:s", strtotime($key['target_date']));
                    $update_sp->sp_logs_planned = $key['percentage'];
                    $update_sp->sp_logs_actual = null;
                    $update_sp->sp_logs_slippage = null;
                    $update_sp->sp_logs_variation_order = 0;
                    $update_sp->sp_logs_spcr = 0;
                    $update_sp->sp_logs_issues = null;
                    $update_sp->sp_logs_analysis = null;
                    $update_sp->sp_logs_remarks = null;
                    $update_sp->sp_logs_esmr = 0;
                    $update_sp->sp_logs_csr = 0;
                    $update_sp->sp_logs_last_user_update = Auth::User()->id; //Employee ID
                    $update_sp->save();
                }
                DB::commit();

                return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return $e->getMessage();
            }
        ob_end_flush();
    }

    public function delete_sp_plan(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();

            try {
                Sp_logs::where('sp_id',$rq->sp_id)->delete();
                DB::commit();

                return 1;
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
                // something went wrong
            }
        ob_end_flush();

    }


    public function fetch_all_for_export(Request $rq){
        $assigned_grouping_array = [1,2,3,4,5,6];

        $sp_ongoing_all_sp_logs = Sp::with('Assigned_grouping')
        ->with(['Assigned_grouping.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->with(['Assigned_sp.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->with('Sp_logs')
        ->with('Sp_batch')
        ->with('Sp_cycle')
        ->with('Sp_groupings')
        ->with('Sp_category')
        ->with('Sp_type')
        ->whereIn('sp_groupings',$assigned_grouping_array)
        ->orderBy('updated_at', 'DESC')
        ->get();
        return $sp_ongoing_all_sp_logs;
    }

    public function search_data_modal(Request $rq){
        ob_start('ob_gzhandler');
            $query = Sp::query();
            if ($rq->has('search_status')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_status', $rq->search_status);
            }
            if ($rq->has('search_modality')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_groupings', $rq->search_modality);
            }

            if ($rq->has('search_year')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_implementation', $rq->search_year);
            }

            if ($rq->has('search_cycle')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_cycle', $rq->search_cycle);
            }

            if ($rq->has('search_batch')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_batch', $rq->search_batch);
            }

            if ($rq->has('province_data')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_province', $rq->province_data['name']);
            }

            if ($rq->has('municipality_data')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_municipality', $rq->municipality_data['name']);
            }

            if ($rq->has('brgy_data')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_brgy', $rq->brgy_data['name']);
            }

            if ($rq->has('search_title')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_title', $rq->search_title);
            }

            if ($rq->has('search_sp_id')) {
                $query = $query->with(['Sp_logs' => function($query){
                return $query->where('sp_logs_actual','<>',null)->get();
            }])
            ->with(['Assigned_grouping.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Assigned_sp.Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')->where('sp_id', $rq->search_sp_id);
            }

            // $scrapper1 = $query->paginate(10);
            $scrapper2 = $query->get();
            // Continue for all of the filters.

            return $scrapper2;

        ob_end_flush();
    }

    public function fetch_reports_modality(Request $rq){
        // Check if as na belong nga sp_groupings
        $assigned_grouping_array = [1,2,3,4,5,6];

        $sp_ongoing_all_sp_logs = Sp::with(['Assigned_grouping.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->with(['Assigned_sp.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->with(['Sp_logs' => function($query){
            $query->whereNotNull('sp_logs_actual')->get();
        }])
        ->with('Sp_batch')
        ->with('Sp_cycle')
        ->with('Sp_groupings')
        ->with('Sp_category')
        ->with('Sp_type')
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
        ->with('CMFS_kalahi_2019_NCDDP_SP')
        ->with('CMFS_kalahi_2020_NCDDP_SP')
        ->with('CMFS_kalahi_2021_NCDDP_SP')
        ->with('CMFS_kalahi_2015_NCDDP_RFR')
        ->with('CMFS_kalahi_2016_NCDDP_RFR')
        ->with('CMFS_kalahi_2017_NCDDP_RFR')
        ->with('CMFS_kalahi_2018_NCDDP_RFR')
        ->with('CMFS_kalahi_2019_NCDDP_RFR')
        ->with('CMFS_kalahi_2020_NCDDP_RFR')
        ->with('CMFS_kalahi_2021_NCDDP_RFR')
        ->whereIn('sp_groupings',$assigned_grouping_array)
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);
        
        return $sp_ongoing_all_sp_logs;
    }

    public function upload_file(Request $rq){
        ob_start('ob_gzhandler');
        foreach ($rq->file as $key) {
            $name = $key->getClientOriginalName();
            $user_folder = Auth::User()->username;

            $addnew = new Files;
            $addnew->filename = $name;
            $addnew->origin = Auth::User()->id;
            $addnew->category = $rq->category;
            Storage::disk("public")->put("profile/ADMIN/$user_folder/$rq->category/$name",file_get_contents($key));
            $addnew->path = "profile/ADMIN/$user_folder/$rq->category/$name";
            $addnew->save();
        }
        return 1;
        ob_end_flush();
    }

}
// End Admin Controller