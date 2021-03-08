<?php

namespace App\Http\Controllers;

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
class ADMIN_RCIS_Controller extends Controller
{
    public function index(){
        return view('user_admin_rcis.home');
    }

    public function show_dashboard(){
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
            ->orWhere('sp_id',2018030002)
            ->orWhere('sp_id',2018030040)
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
		$ongoing = Sp::whereIn('sp_implementation',[2020,2018])->where('sp_status', 'On-going')->get()->groupBy('sp_groupings');
		// $ongoing = Sp::where('sp_implementation',2020)->where('sp_status', 'On-going')->get()->groupBy('sp_groupings');
		$completed = Sp::where('sp_implementation',2020)->where('sp_status', 'Completed')->get()->groupBy('sp_groupings');

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

    public function profile(){
        return view('user_admin_rcis.profile');
    }

    public function summary(){
        return view('user_admin_rcis.summary');
    }

    public function show_summary(){
    	ob_start('ob_gzhandler');
    	// return Sp::with('Sp_logs')->with('Sp_groupings')->with('Sp_category')->with('Sp_type')->whereYear('sp_date_started','2015')->get();
    	// Monthly Target
		$target = Sp::with('Sp_logs')
			->where('sp_implementation',2020)
			->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
			->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
			->where('sp_target_date_of_completion','<>', '')
			->whereIn('sp_status',['NYS','On-going','Completed'])
			->whereIn('sp_groupings',[3,4])
			->get()
			->groupBy(function($d) {
				return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
			})
			->map(function($users) {
		        return [$users->count()];
		    });

		$actual = Sp::with('Sp_logs')
			->where('sp_implementation',2020)
			->where('sp_target_date_of_completion','<>', '0001-01-01 00:00:00')
			->where('sp_target_date_of_completion','<>', '0000-00-00 00:00:00')
			->where('sp_target_date_of_completion','<>', '')
			->whereIn('sp_status',['NYS','On-going','Completed'])
			->whereIn('sp_groupings',[3,4])
			->get()
			->groupBy(function($d) {
				return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
			})->map(function($users) {
		        return [$users->count()];
		    });

		$Completed_per_grouping = Sp::whereIn('sp_groupings',[3,4])->where('sp_status','Completed')
			->where('sp_implementation',2020)
			->get()
			->groupBy('sp_groupings')
			->map(function($users) {
		        return [$users->count()];
		    });

		$Ongoing_per_grouping = Sp::whereIn('sp_groupings',[3,4])->where('sp_status','On-going')
			->where('sp_implementation',2020)
			->get()
			->groupBy('sp_groupings')
			->map(function($users) {
		        return [$users->count()];
		    });
		$NYS_per_grouping = Sp::whereIn('sp_groupings',[3,4])->where('sp_status','NYS')
			->get()
			->groupBy('sp_groupings')
			->map(function($users) {
		        return [$users->count()];
		    });


		$Chart_Sp_type = Sp::where('sp_type', '<>', '')
			->where('sp_implementation',2020)
			->whereNotNull('sp_type')
			->with('Sp_type')
			->get()
			->groupBy('Sp_type.type')
			->map(function($users) {
		        return [$users->count()];
		    });

		$Chart_Sp_category = Sp::where('sp_category', '<>', '')
			->where('sp_implementation',2020)
			->whereNotNull('sp_category')
			->get()
			->groupBy('sp_category')
			->map(function($users) {
		        return [$users->count()];
		    });


		$all_sp = null;

		// $all_sp = Sp::with(['Sp_logs' => function($query){
		// 	return $query->where('sp_logs_actual','<>',null)->get();
		//	}])
		//	->with('Cadt')
		//	->with('Sp_batch')
		//	->with('Sp_cycle')
		//	->with('Sp_category')
		//	->with('Sp_type')
		//	->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		//	    $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		//	}])
		//	->with(['Assigned_sp.Users' => function($query2){
		//	    $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		//	}])
		//	->orderBy('id', 'DESC')
		//	->get();

		$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
			->where('sp_implementation','2020')
			->where('sp_type', '<>', '')
			->whereNotNull('sp_type')
			->with('Sp_type')
			->get()
			->groupBy('Sp_type.type')
			->map(function($users) {
		        return round($users->avg('sp_estimated_duration'),0);
		    });

		$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
			->where('sp_implementation','2020')
			->where('sp_type', '<>', '')
	    	->where('sp_date_started','<>','0000-00-00 00:00:00')
	    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
			->whereNotNull('sp_type')
			->with('Sp_type')
			->get()
			->groupBy('Sp_type.type')
			->map(function($users) {
		        // return $users->avg('sp_estimated_duration');
    			$arr = [];
		        // return strtotime($users['sp_date_started']);
				foreach ($users as $key) {
					$date_1 = strtotime($key->sp_date_started);
					// date('Y-m-d',$key->sp_target_date_of_completion);

					$date_2 = strtotime($key->sp_actual_date_completed);
					// date('Y-m-d',$key->sp_actual_date_completed);

					// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
					array_push($arr, (($date_2 - $date_1) / (60*60*24)));
				}
				return round(array_sum($arr) / count($arr),0);
		    });

		return [
			$target,
			$actual,
			$actual->max(),
			$Completed_per_grouping,
			$Ongoing_per_grouping,
			$NYS_per_grouping,
			$Chart_Sp_type,
			$Chart_Sp_category,
			$all_sp,
			$Chart_Sp_type_Estimated_Duration,
			$Chart_Sp_type_Actual_Duration
		];

		// Max count sa 
		// return $months->max();
        ob_end_flush();
    }
    
    public function show_modal_summary(Request $rq){
		ob_start('ob_gzhandler');
			if ($rq->has('search_modality')) {
				$target = Sp::with('Sp_logs')
					->orWhere('sp_groupings',$rq->search_modality)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->where('sp_groupings',$rq->search_modality)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->where('sp_groupings',$rq->search_modality)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->where('sp_groupings',$rq->search_modality)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->where('sp_groupings',$rq->search_modality)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->where('sp_groupings',$rq->search_modality)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->where('sp_groupings',$rq->search_modality)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				// $all_sp = null;

				$all_sp = Sp::with(['Sp_logs' => function($query){
					return $query->where('sp_logs_actual','<>',null)->get();
				      }])
				->where('sp_groupings',$rq->search_modality)
				      ->with('Cadt')
				      ->with('Sp_batch')
				      ->with('Sp_cycle')
				      ->with('Sp_category')
				      ->with('Sp_type')
				      ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
				          $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
				      }])
				      ->with(['Assigned_sp.Users' => function($query2){
				          $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
				      }])
				      ->orderBy('id', 'DESC')
				      ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::where('sp_groupings',$rq->search_modality)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::where('sp_groupings',$rq->search_modality)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });

			}else if ($rq->has('search_year')) {
				$target = Sp::with('Sp_logs')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					// ->whereYear('sp_date_started', $rq->search_year)
					->where('sp_implementation', $rq->search_year)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				// $all_sp = null;

				$all_sp = Sp::with(['Sp_logs' => function($query){
					return $query->where('sp_logs_actual','<>',null)->get();
		        }])
		        ->with('Cadt')
		        ->with('Sp_batch')
		        ->with('Sp_cycle')
		        ->with('Sp_category')
		        ->with('Sp_type')
		        ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		            $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		        }])
		        ->with(['Assigned_sp.Users' => function($query2){
		            $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		        }])
				->where('sp_implementation',$rq->search_year)
		        ->orderBy('id', 'DESC')
		        ->get();

			$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
				->where('sp_type', '<>', '')
				->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				->whereYear('sp_date_started', $rq->search_year)
				->whereNotNull('sp_type')
				->with('Sp_type')
				->get()
				->groupBy('Sp_type.type')
				->map(function($users) {
			        return round($users->avg('sp_estimated_duration'),0);
			    });

			$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
				->where('sp_type', '<>', '')
				->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				->whereYear('sp_date_started', $rq->search_year)
		    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
				->whereNotNull('sp_type')
				->with('Sp_type')
				->get()
				->groupBy('Sp_type.type')
				->map(function($users) {
			        // return $users->avg('sp_estimated_duration');
	    			$arr = [];
			        // return strtotime($users['sp_date_started']);
					foreach ($users as $key) {
						$date_1 = strtotime($key->sp_date_started);
						// date('Y-m-d',$key->sp_target_date_of_completion);

						$date_2 = strtotime($key->sp_actual_date_completed);
						// date('Y-m-d',$key->sp_actual_date_completed);

						// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
						array_push($arr, (($date_2 - $date_1) / (60*60*24)));
					}
					return round(array_sum($arr) / count($arr),0);
			    });

			}else if ($rq->has('search_cycle')) {
				$target = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_cycle', $rq->search_cycle)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				$all_sp = null;

				// $all_sp = Sp::with(['Sp_logs' => function($query){
				// 	return $query->where('sp_logs_actual','<>',null)->get();
		  //       }])
		  //       ->with('Cadt')
		  //       ->with('Sp_batch')
		  //       ->with('Sp_cycle')
		  //       ->with('Sp_category')
		  //       ->with('Sp_type')
		  //       ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		  //           $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
		  //       ->with(['Assigned_sp.Users' => function($query2){
		  //           $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
				// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				// ->where('Sp.sp_cycle', $rq->search_cycle)
		  //       ->orderBy('id', 'DESC')
		  //       ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('Sp.sp_cycle',$rq->search_cycle)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('Sp.sp_cycle',$rq->search_cycle)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });
				
			}else if ($rq->has('search_batch')) {
				$target = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('Sp.sp_batch', $rq->search_batch)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				$all_sp = null;

				// $all_sp = Sp::with(['Sp_logs' => function($query){
				// 	return $query->where('sp_logs_actual','<>',null)->get();
		  //       }])
		  //       ->with('Cadt')
		  //       ->with('Sp_batch')
		  //       ->with('Sp_cycle')
		  //       ->with('Sp_category')
		  //       ->with('Sp_type')
		  //       ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		  //           $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
		  //       ->with(['Assigned_sp.Users' => function($query2){
		  //           $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
				// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				// ->where('Sp.sp_batch', $rq->search_batch)
		  //       ->orderBy('id', 'DESC')
		  //       ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('Sp.sp_batch',$rq->search_batch)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('Sp.sp_batch',$rq->search_batch)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });

			}else if ($rq->has('province_data')) {
				$target = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_province', $rq->province_data)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				$all_sp = null;

				// $all_sp = Sp::with(['Sp_logs' => function($query){
				// 	return $query->where('sp_logs_actual','<>',null)->get();
		  //       }])
		  //       ->with('Cadt')
		  //       ->with('Sp_batch')
		  //       ->with('Sp_cycle')
		  //       ->with('Sp_category')
		  //       ->with('Sp_type')
		  //       ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		  //           $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
		  //       ->with(['Assigned_sp.Users' => function($query2){
		  //           $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
				// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				// ->where('sp_province', $rq->province_data)
		  //       ->orderBy('id', 'DESC')
		  //       ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_province',$rq->province_data)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_province',$rq->province_data)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });
				
			}else if ($rq->has('municipality_data')) {
				$target = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_municipality', $rq->municipality_data)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				$all_sp = null;

				// $all_sp = Sp::with(['Sp_logs' => function($query){
				// 	return $query->where('sp_logs_actual','<>',null)->get();
		  //       }])
		  //       ->with('Cadt')
		  //       ->with('Sp_batch')
		  //       ->with('Sp_cycle')
		  //       ->with('Sp_category')
		  //       ->with('Sp_type')
		  //       ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		  //           $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
		  //       ->with(['Assigned_sp.Users' => function($query2){
		  //           $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
				// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				// ->where('sp_municipality', $rq->municipality_data)
		  //       ->orderBy('id', 'DESC')
		  //       ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_municipality',$rq->municipality_data)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_municipality',$rq->municipality_data)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });

			}else if ($rq->has('brgy_data')) {
				$target = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_target_date_of_completion)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$actual = Sp::with('Sp_logs')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->get()
					->groupBy(function($d) {
						return Carbon::parse($d->sp_actual_date_completed)->locale('en')->monthName;
					})->map(function($users) {
				        return [$users->count()];
				    });

				$Completed_per_grouping = Sp::where('sp_status','Completed')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Ongoing_per_grouping = Sp::where('sp_status','On-going')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$NYS_per_grouping = Sp::where('sp_status','NYS')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->get()
					->groupBy('sp_groupings')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_type = Sp::where('sp_type', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					// ->groupBy('sp_type')
					->map(function($users) {
				        return [$users->count()];
				    });

				$Chart_Sp_category = Sp::where('sp_category', '<>', '')
					->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
					->where('sp_brgy', $rq->brgy_data)
					->whereNotNull('sp_category')
					->with('Sp_category')
					->get()
					->groupBy('Sp_category.category')
					->map(function($users) {
				        return [$users->count()];
				    });

				$all_sp = null;

				// $all_sp = Sp::with(['Sp_logs' => function($query){
				// 	return $query->where('sp_logs_actual','<>',null)->get();
		  //       }])
		  //       ->with('Cadt')
		  //       ->with('Sp_batch')
		  //       ->with('Sp_cycle')
		  //       ->with('Sp_category')
		  //       ->with('Sp_type')
		  //       ->with(['Sp_groupings.Assigned_grouping.Users' => function($query1){
		  //           $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
		  //       ->with(['Assigned_sp.Users' => function($query2){
		  //           $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
		  //       }])
				// ->whereYear('sp_date_started', '<>', '0000-00-00 00:00:00')
				// ->where('sp_brgy', $rq->brgy_data)
		  //       ->orderBy('id', 'DESC')
		  //       ->get();

				$Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_brgy',$rq->brgy_data)
					->where('sp_type', '<>', '')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        return $users->avg('sp_estimated_duration');
				    });

				$Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[3,4])
					->where('sp_brgy',$rq->brgy_data)
					->where('sp_type', '<>', '')
			    	->where('sp_date_started','<>','0000-00-00 00:00:00')
			    	->where('sp_actual_date_completed', '<>', '0000-00-00 00:00:00')
					->whereNotNull('sp_type')
					->with('Sp_type')
					->get()
					->groupBy('Sp_type.type')
					->map(function($users) {
				        // return $users->avg('sp_estimated_duration');
		    			$arr = [];
				        // return strtotime($users['sp_date_started']);
						foreach ($users as $key) {
							$date_1 = strtotime($key->sp_date_started);
							// date('Y-m-d',$key->sp_target_date_of_completion);

							$date_2 = strtotime($key->sp_actual_date_completed);
							// date('Y-m-d',$key->sp_actual_date_completed);

							// array_push($arr, floor(($date_2 - $date_1) / (60*60*24)));
							array_push($arr, (($date_2 - $date_1) / (60*60*24)));
						}
						return round(array_sum($arr) / count($arr));
				    });
			}else;

			return [
				$target,
				$actual,
				$actual->max(),
				$Completed_per_grouping,
				$Ongoing_per_grouping,
				$NYS_per_grouping,
				$Chart_Sp_type,
				$Chart_Sp_category,
				$all_sp,
				$Chart_Sp_type_Estimated_Duration,
				$Chart_Sp_type_Actual_Duration
			];
    	ob_end_flush();
    }

    public function downloadables(){
        return view('user_admin_rcis.downloadables');
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

    public function upload_file(Request $rq){
        ob_start('ob_gzhandler');
        foreach ($rq->file as $key) {
            $name = $key->getClientOriginalName();
            $user_folder = Auth::User()->username;

            $addnew = new Files;
            $addnew->filename = $name;
            $addnew->origin = Auth::User()->id;
            $addnew->category = $rq->category;
            Storage::disk("public")->put("profile/RCIS/$user_folder/$rq->category/$name",file_get_contents($key));
            $addnew->path = "profile/RCIS/$user_folder/$rq->category/$name";
            $addnew->save();
        }
        return "success";
        ob_end_flush();
    }

    public function modality(){
        return view('user_admin_rcis.modality');
    }

    public function fetch_all_modality_sp(Request $rq){
    	ob_start('ob_gzhandler');

        $sp_ongoing_all_sp_logs = Sp::with('Assigned_grouping')
        ->with(['Assigned_grouping.Users' => function($e){
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
		// ->with('CMFS_kalahi_2018_NCDDP_SP')
		->with('CMFS_kalahi_2019_NCDDP_SP')
		->with('CMFS_kalahi_2020_NCDDP_SP')
		->with('CMFS_kalahi_2015_NCDDP_RFR')
		->with('CMFS_kalahi_2016_NCDDP_RFR')
		->with('CMFS_kalahi_2017_NCDDP_RFR')
		->with('CMFS_kalahi_2018_NCDDP_RFR')
		->with('CMFS_kalahi_2019_NCDDP_RFR')
		->with('CMFS_kalahi_2020_NCDDP_RFR')
        // ->orderBy('sp_implementation', 'DESC')
        ->orderBy('sp_implementation', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->paginate(100);

        return $sp_ongoing_all_sp_logs;
        ob_end_flush();
    }

    public function fetch_all_for_export(Request $rq){
        $sp_ongoing_all_sp_logs = Sp::with(['Sp_logs' => function($query){
			return $query->where('sp_logs_actual','<>',null)->get();
        }])
        ->with('Sp_batch')
        ->with('Assigned_sp.Users')
		->with('Sp_groupings.Assigned_grouping.Users')
        ->with('Sp_cycle')
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
		// ->with('CMFS_kalahi_2018_NCDDP_SP')
		->with('CMFS_kalahi_2019_NCDDP_SP')
		->with('CMFS_kalahi_2020_NCDDP_SP')
		->with('CMFS_kalahi_2015_NCDDP_RFR')
		->with('CMFS_kalahi_2016_NCDDP_RFR')
		->with('CMFS_kalahi_2017_NCDDP_RFR')
		->with('CMFS_kalahi_2018_NCDDP_RFR')
		->with('CMFS_kalahi_2019_NCDDP_RFR')
		->with('CMFS_kalahi_2020_NCDDP_RFR')
        ->with(['Assigned_grouping.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->with(['Assigned_sp.Users' => function($e){
            $e->select('id','Fname','Lname')->get();
        }])
        ->orderBy('updated_at', 'DESC')
        ->get();

        return $sp_ongoing_all_sp_logs;
    }

    public function view_planned_sched(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->orderBy('sp_logs_planned_target_date')->get();
        ob_end_flush();
    }
    
    public function fetch_search_modality_sp(Request $rq){
        // if($rq->params == null){
        // 	return $this->fetch_all_modality_sp($rq);
        // }else{
	        $sp_ongoing_all_sp_logs = Sp::with('Assigned_grouping')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
            ->with(['Sp_logs' => function($query){
                $query->whereNotNull('sp_logs_actual')->orderBy('id','asc')->get();
            }])
	        ->with('Sp_batch')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
			->where('sp_status',  'like', "%".$rq->params."%")
			->orWhere('sp_id',  'like', "%".$rq->params."%")
			->orWhere('sp_title', 'like', "%".$rq->params."%")
			->orWhere('sp_province', 'like', "%".$rq->params."%")
			->orWhere('sp_municipality', 'like', "%".$rq->params."%")
			->orWhere('sp_brgy', 'like', "%".$rq->params."%")
			->orWhere('sp_cycle', 'like', "%".$rq->params."%")
			->orWhere('sp_batch', 'like', "%".$rq->params."%")
			->orWhere('sp_implementation', 'like', "%".$rq->params."%")
	    	->orderBy('updated_at', 'DESC')
	        ->paginate(100);

	        $sp_ongoing_all_sp_logs_for_export = Sp::with('Assigned_grouping')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
            ->with(['Sp_logs' => function($query){
                $query->whereNotNull('sp_logs_actual')->orderBy('id','asc')->get();
            }])
	        ->with('Sp_batch')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
			->where('sp_status',  'like', "%".$rq->params."%")
			->orWhere('sp_id',  'like', "%".$rq->params."%")
			->orWhere('sp_title', 'like', "%".$rq->params."%")
			->orWhere('sp_province', 'like', "%".$rq->params."%")
			->orWhere('sp_municipality', 'like', "%".$rq->params."%")
			->orWhere('sp_brgy', 'like', "%".$rq->params."%")
			->orWhere('sp_cycle', 'like', "%".$rq->params."%")
			->orWhere('sp_batch', 'like', "%".$rq->params."%")
			->orWhere('sp_implementation', 'like', "%".$rq->params."%")
	    	->orderBy('updated_at', 'DESC')
	        ->get();
	        return [$sp_ongoing_all_sp_logs,$sp_ongoing_all_sp_logs_for_export];
        // }
    }

    public function search_data_modal(Request $rq){
		ob_start('ob_gzhandler');

		    $query = Sp::query();
		    if ($rq->has('search_status')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_status', $rq->search_status);
		    }

		    if ($rq->has('search_modality')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_groupings',$rq->search_modality);
		    }

		    if ($rq->has('search_year')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_batch')
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->with('Sp_type')
	        ->where('sp_implementation', $rq->search_year);
		    }

		    if ($rq->has('search_cycle')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_cycle', 'like',$rq->search_cycle);
		    }

		    if ($rq->has('search_batch')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_batch', $rq->search_batch);
		    }

		    if ($rq->has('province_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_province', $rq->province_data['name']);
		    }

		    if ($rq->has('municipality_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_municipality', 'like',$rq->municipality_data['name']);
		    }

		    if ($rq->has('brgy_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_brgy', $rq->brgy_data['name']);
		    }

		    if ($rq->has('search_title')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_title', $rq->search_title);
		    }

		    if ($rq->has('search_sp_id')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_id', $rq->search_sp_id);
		    }

		    $scrapper1 = $query->paginate(100);
		    // Continue for all of the filters.

            return [$scrapper1,$this->yawaaaaaa_get_all_modal_Data($rq)];


    	ob_end_flush();
    }

    public function yawaaaaaa_get_all_modal_Data(Request $rq){
		    $query = Sp::query();
		    if ($rq->has('search_status')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_status', $rq->search_status);
		    }

		    if ($rq->has('search_modality')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_groupings',$rq->search_modality);
		    }

		    if ($rq->has('search_year')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_batch')
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->with('Sp_type')
	        ->where('sp_implementation', $rq->search_year);
		    }

		    if ($rq->has('search_cycle')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_cycle', 'like',$rq->search_cycle);
		    }

		    if ($rq->has('search_batch')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_batch', $rq->search_batch);
		    }

		    if ($rq->has('province_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_province', $rq->province_data['name']);
		    }

		    if ($rq->has('municipality_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_municipality', 'like',$rq->municipality_data['name']);
		    }

		    if ($rq->has('brgy_data')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_brgy', $rq->brgy_data['name']);
		    }

		    if ($rq->has('search_title')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_title', $rq->search_title);
		    }

		    if ($rq->has('search_sp_id')) {
		        $xx = $query
		        ->with(['Sp_logs' => function($query){
				return $query->where('sp_logs_actual','<>',null)->get();
			}])
	        ->with('Sp_batch')
	        ->with(['Assigned_grouping.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with(['Assigned_sp.Users' => function($e){
	            $e->select('id','Fname','Lname')->get();
	        }])
	        ->with('Sp_type')
	        ->with('Sp_cycle')
	        ->with('Sp_groupings.Assigned_grouping.Users')
	        ->with('Sp_category')
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
			// ->with('CMFS_kalahi_2018_NCDDP_SP')
			->with('CMFS_kalahi_2019_NCDDP_SP')
			->with('CMFS_kalahi_2020_NCDDP_SP')
			->with('CMFS_kalahi_2015_NCDDP_RFR')
			->with('CMFS_kalahi_2016_NCDDP_RFR')
			->with('CMFS_kalahi_2017_NCDDP_RFR')
			->with('CMFS_kalahi_2018_NCDDP_RFR')
			->with('CMFS_kalahi_2019_NCDDP_RFR')
			->with('CMFS_kalahi_2020_NCDDP_RFR')
	        ->where('sp_id', $rq->search_sp_id);
		    }

		    $scrapper2 = $query->get();
		    // Continue for all of the filters.
            return $scrapper2;
    }

}
