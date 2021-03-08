<?php

namespace App\Http\Controllers;
include("../vendor/autoload.php");

use Illuminate\Http\Request;
/* for Socket */
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
/* for Socket */

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

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
use App\Cadt;
use App\Files;
use App\Users;
use App\Sms;
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

class PROCUREMENT_Controller extends Controller
{
    public function index(){
        return view('user_procurement.home');
    }

    public function profile(){
        return view('user_procurement.profile');
    }

    public function show_file(Request $rq){
        return view('user_procurement.upload');
    }

    public function show_modality(Request $rq){
        return view('user_procurement.modality');
    }
    
    public function fetch_modality_dashboard(Request $rq){
        // Get modality where user is asigned
        $modality = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('sp_grouping_id');

        // Recently Edited sp Count_Ongoing_sp
        $groupings_sp = Assigned_grouping::with(['Sp' => function($query1){
           $query1->with('Sp_type')
            ->with('Sp_category')
            ->with('Sp_groupings')
            ->with(['Sp_logs' => function($query){
                $query->whereNotNull('sp_logs_actual')->get();
            }])
            ->where('sp_status','On-going')
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();
        }])
        ->where('assigned_to',Auth::User()->id)
        ->get();

        // ON GOING
        // $Count_Ongoing_sp_data = Assigned_grouping::with(['Sp' => function($query1){
        //    $query1->where('sp_status','On-going')->get();
        // }])
        // ->where('assigned_to',Auth::User()->id)
        // ->get();

        // $Count_Ongoing_sp = $Count_Ongoing_sp_data->map(function ($item, $key) {
        //     return $item->sp->whereIn('sp_status', 'On-going')->count();
        // })->sum();

        $Count_Ongoing_sp = Sp::where('sp_status','On-going')->get()->count();
        // ON GOING

        // NYS
        // $Count_NYS_sp_data = Assigned_grouping::with(['Sp' => function($query1){
        //    $query1->where('sp_status','NYS')->get();
        // }])
        // ->where('assigned_to',Auth::User()->id)
        // ->get();

        // $Count_NYS_sp = $Count_NYS_sp_data->map(function ($item, $key) {
        //     return $item->sp->whereIn('sp_status', 'NYS')->count();
        // })->sum();

        $Count_NYS_sp = Sp::where('sp_status','NYS')->where('sp_implementation', 2020)->get()->count();
        // NYS

        // COMPLETED
        // $Count_Completed_sp_data = Assigned_grouping::with(['Sp' => function($query1){
        //    return $query1->where('sp_status','Completed')->count();
        // }])
        // ->where('assigned_to',Auth::User()->id)
        // ->get();

        // $Count_Completed_sp = $Count_Completed_sp_data->map(function ($item, $key) {
        //     return $item->sp->whereIn('sp_implementation', 2020)->whereIn('sp_status', 'Completed')->count();
        // })->sum();

        $Count_Completed_sp = Sp::where('sp_status','Completed')->where('sp_implementation', 2020)->get()->count();
        // COMPLETED

        // PMR
        $pmr_approved = Sp_pmr::where('status', 'Reviewed')->count();
        $pmr_pending = Sp_pmr::where('status', 'On-going')->count();
        $pmr_for_update = Sp_pmr::where('status', 'For update')->count();

        $approved_per_sp_groupings = Sp_pmr::with(['Sp' => function($query){
            return $query->select('sp_id','sp_groupings')->get();
        }])->where('status', 'Approved')->get()->groupby('Sp.sp_groupings');

        $pending_per_sp_groupings = Sp_pmr::with(['Sp' => function($query){
            return $query->select('sp_id','sp_groupings')->get();
        }])->where('status', 'Pending')->get()->groupby('Sp.sp_groupings');

        $forupdate_per_sp_groupings = Sp_pmr::with(['Sp' => function($query){
            return $query->select('sp_id','sp_groupings')->get();
        }])->where('status', 'For update')->get()->groupby('Sp.sp_groupings');

        $latest_pmr = Sp_pmr::with(['Sp' => function($query){
            return $query->select('sp_id','sp_title')->get();
        }])->with(['Sp_pmr_logs' => function($query){
            return $query->limit(3)->get();
        }])->orderBy('updated_at', 'desc')->limit(1)->get();

        $pmr_logs_events = sp_pmr_remarks_logs::get();
        return [$modality,$groupings_sp,$Count_Ongoing_sp,$Count_Completed_sp,$Count_NYS_sp,$pmr_approved,$pmr_pending,$pmr_for_update,$approved_per_sp_groupings,$pending_per_sp_groupings,$forupdate_per_sp_groupings,$latest_pmr,$pmr_logs_events];
    }

    public function fetch_all_modality_sp(Request $rq){
        ob_start('ob_gzhandler');
        $now = Carbon::now();

        $sp_ongoing_all_sp_logs = Sp::with('Assigned_grouping')
        // ->with('Sp_logs')
        ->with(['Sp_logs' => function($query){
            $query->whereNotNull('sp_logs_actual')->get();
        }])
        ->with('Sp_pmr.Sp_pmr_logs')
        ->with('Sp_pmr.Sp_pmr_remarks_logs')
        ->with('Sp_batch')
        ->with('Sp_cycle')
        ->with('Sp_groupings')
        ->with('Sp_category')
        ->with('Sp_type')
        ->whereIn('sp_implementation', [2020,2019])
        ->orderBy('sp_implementation', 'DESC')
        ->paginate(100);

        // $sp_ongoing_all_sp_logs_all_export_all = Sp::with('Assigned_grouping')
        // ->with(['Assigned_grouping.Users' => function($e){
        //     $e->select('id','Fname','Lname')->get();
        // }])
        // ->with(['Assigned_sp.Users' => function($e){
        //     $e->select('id','Fname','Lname')->get();
        // }])
        // ->with(['Sp_logs' => function($query){
        //     $query->whereNotNull('sp_logs_actual')->get();
        // }])
        // ->with('Sp_pmr.Sp_pmr_logs')
        // ->with('Sp_pmr.Sp_pmr_remarks_logs')
        // ->with('Sp_batch')
        // ->with('Sp_cycle')
        // ->with('Sp_groupings')
        // ->with('Sp_category')
        // ->with('Sp_type')
        // ->whereIn('sp_implementation', [2020,2019])
        // ->orderBy('sp_implementation', 'DESC')
        // ->get();

        return $sp_ongoing_all_sp_logs;
        // return [$sp_ongoing_all_sp_logs,$sp_ongoing_all_sp_logs_all_export_all];
        ob_end_flush();
    }

    public function fetch_all_pmr(Request $rq){
        ob_start('ob_gzhandler');

        $sp_pmr = Sp_pmr::with(['Sp' => function($w){
            return $w->orderBy('sp_province', 'ASC')->get();
        }])
        ->with('Sp_pmr_logs')
        ->with('Sp_pmr_remarks_logs')
        ->get();

        return $sp_pmr;
        ob_end_flush();
    }
    
    public function fetch_search_modality_sp(Request $rq){
        if($rq->params == null){
            return $this->fetch_all_modality_sp($rq);
        }else{
            // if($rq->params == 100 || $rq->params == 'Completed'){
            // }else{
            $sp_ongoing_all_sp_logs = Sp::with('Assigned_grouping')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_logs')
            ->with('Sp_batch')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')
            ->where('sp_id', $rq->params)
            ->orWhere('sp_title', 'like', "%".$rq->params."%")
            ->orWhere('sp_province', 'like', "%".$rq->params."%")
            ->orWhere('sp_municipality', 'like', "%".$rq->params."%")
            ->orWhere('sp_brgy', 'like', "%".$rq->params."%")
            ->orderBy('updated_at', 'DESC')
            ->paginate(100);
            return $sp_ongoing_all_sp_logs;
            // }
        }
    }

    public function search_data_modal(Request $rq){
        ob_start('ob_gzhandler');

            $query = Sp::query();
            if ($rq->has('search_modality')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_groupings',$rq->search_modality);
            }

            if ($rq->has('search_year')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->with('Sp_type')
            ->whereIn('sp_implementation', [2020,2019])
            ->whereYear('sp_implementation', $rq->search_year);
            }

            if ($rq->has('search_cycle')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_cycle', 'like',$rq->search_cycle);
            }

            if ($rq->has('search_batch')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_batch', $rq->search_batch);
            }

            if ($rq->has('province_data')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_province', 'like', '%'.$rq->province_data['name'].'%');
            }

            if ($rq->has('municipality_data')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_municipality', 'like', '%'.$rq->municipality_data['name'].'%');
            }

            if ($rq->has('brgy_data')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_brgy', $rq->brgy_data['name']);
            }

            if ($rq->has('search_title')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_title', $rq->search_title);
            }

            if ($rq->has('search_sp_id')) {
                $query = $query
            ->with('Sp_logs')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp_batch')
            ->with('Sp_type')
            ->with('Sp_cycle')
            ->with('Sp_groupings')
            ->with('Sp_category')
            ->whereIn('sp_implementation', [2020,2019])
            ->where('sp_id', $rq->search_sp_id);
            }

            $scrapper1 = $query->paginate(200);
            $scrapper2 = $query->get();
            // Continue for all of the filters.
            return [$scrapper1, $scrapper2];

        ob_end_flush();
    }

    public function fetch_all_for_export(Request $rq){
        $sp_ongoing_all_sp_logs = Sp::with(['Sp_logs' => function($query){
            return $query->where('sp_logs_actual','<>',null)->get();
        }])
        ->with('Sp_batch')
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
        ->with(['Assigned_grouping.Users' => function($query1){
            $query1->select('id','Fname','Lname','emp_id_no','contact','role')->get();
        }])
        ->with(['Assigned_sp.Users' => function($query2){
            $query2->select('id','Fname','Lname','emp_id_no','contact','role')->get();
        }])
        ->where('sp_implementation',2020)
        ->orderBy('updated_at', 'DESC')
        ->get();

        return $sp_ongoing_all_sp_logs;
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

                $all_sp = null;

                // $all_sp = Sp::with(['Sp_logs' => function($query){
                //  return $query->where('sp_logs_actual','<>',null)->get();
          //       }])
                // ->where('sp_groupings',$rq->search_modality)
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
          //       ->orderBy('id', 'DESC')
          //       ->get();

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('sp_groupings',$rq->search_modality)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('sp_groupings',$rq->search_modality)
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

                $all_sp = null;

                // $all_sp = Sp::with(['Sp_logs' => function($query){
                //  return $query->where('sp_logs_actual','<>',null)->get();
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
                // ->whereYear('sp_date_started', $rq->search_year)
          //       ->orderBy('id', 'DESC')
          //       ->get();

            $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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

            $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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
                //  return $query->where('sp_logs_actual','<>',null)->get();
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

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('Sp.sp_cycle',$rq->search_cycle)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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
                //  return $query->where('sp_logs_actual','<>',null)->get();
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

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('Sp.sp_batch',$rq->search_batch)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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
                //  return $query->where('sp_logs_actual','<>',null)->get();
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

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('sp_province',$rq->province_data)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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
                //  return $query->where('sp_logs_actual','<>',null)->get();
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

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('sp_municipality',$rq->municipality_data)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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
                //  return $query->where('sp_logs_actual','<>',null)->get();
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

                $Chart_Sp_type_Estimated_Duration = Sp::whereIn('sp_groupings',[1,3,4])
                    ->where('sp_brgy',$rq->brgy_data)
                    ->where('sp_type', '<>', '')
                    ->whereNotNull('sp_type')
                    ->with('Sp_type')
                    ->get()
                    ->groupBy('Sp_type.type')
                    ->map(function($users) {
                        return $users->avg('sp_estimated_duration');
                    });

                $Chart_Sp_type_Actual_Duration = Sp::whereIn('sp_groupings',[1,3,4])
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

    public function view_planned_sched(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->orderBy('id', 'DESC')->get();
        ob_end_flush();
    }

    public function create_pmr(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                $addnew = new Sp_pmr;
                $addnew->sp_id = $rq->sp_id;
                $addnew->mode_of_procurement = $rq->mode_of_procurement;
                $addnew->nature_of_procurement = $rq->nature_of_procurement;
                $addnew->code = $rq->code;
                $addnew->fund_source = $rq->fund_source;
                $addnew->apa_pre_proc_con = $rq->apa_pre_proc_con;
                $addnew->apa_ads = $rq->apa_ads;
                $addnew->apa_prebid_con = $rq->apa_prebid_con;
                $addnew->apa_eligibility_check = $rq->apa_eligibility_check;
                $addnew->apa_open_of_bids = $rq->apa_open_of_bids;
                $addnew->apa_bid_eval = $rq->apa_bid_eval;
                $addnew->apa_post_qual = $rq->apa_post_qual;
                $addnew->apa_notice_of_award = $rq->apa_notice_of_award;
                $addnew->apa_contract_signing = $rq->apa_contract_signing;
                $addnew->apa_notice_to_proceed = $rq->apa_notice_to_proceed;
                $addnew->apa_delivery = $rq->apa_delivery;
                $addnew->apa_acceptance = $rq->apa_acceptance;
                $addnew->abc_total = $rq->abc_total;
                $addnew->abc_mooe = $rq->abc_mooe;
                $addnew->abc_co = $rq->abc_co;
                $addnew->contract_cost_total = $rq->contract_cost_total;
                $addnew->contract_cost_mooe = $rq->contract_cost_mooe;
                $addnew->contract_cost_co = $rq->contract_cost_co;
                $addnew->list_of_invited = $rq->list_of_invited;
                $addnew->io_prebid_con = $rq->io_prebid_con;
                $addnew->io_eligibility_check = $rq->io_eligibility_check;
                $addnew->io_open_of_bids = $rq->io_open_of_bids;
                $addnew->io_bid_eval = $rq->io_bid_eval;
                $addnew->io_post_qual = $rq->io_post_qual;
                $addnew->delivery = $rq->delivery;
                $addnew->remarks = $rq->remarks;
                $addnew->delivery_percentage = $rq->delivery_percentage;
                $addnew->date_of_posting_philgeps_noa;
                $addnew->save();
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

    public function fetch_specific_sp_pmr_data(Request $rq){
        $sp_pmr = Sp_pmr::where('sp_id',$rq->sp_id)->with('Sp_pmr_remarks_logs')->with('Sp_pmr_logs')->get();

        $sp_pmr_pending = Sp_pmr::select('id','sp_id')->with('Sp_pmr_remarks_logs')->with(['Sp_pmr_logs' => function($e){
            return $e->where('status','Pending')->get();
        }])->where('sp_id',$rq->sp_id)->get();

        $sp_pmr_complied = Sp_pmr::select('id','sp_id')->with('Sp_pmr_remarks_logs')->with(['Sp_pmr_logs' => function($e){
            return $e->where('status','Complied')->get();
        }])->where('sp_id',$rq->sp_id)->get();

        return [$sp_pmr,$sp_pmr_pending,$sp_pmr_complied];
    }

    public function submit_pmr_focal_comments(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            // Update pmr table
            Sp_pmr::where('id',$rq->id)->where('sp_id',$rq->sp_id)->update(array('status' => 'For update'));
            // Add comments to pmr_logs
            $addnew = new Sp_pmr_logs;
            $addnew->pmr_id = $rq->id;
            $addnew->pmr_comments = $rq->pmr_forupdate_comments;
            $addnew->save();

            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function pmr_approve(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            // Update pmr table
            Sp_pmr::where('id',$rq->id)->where('sp_id',$rq->sp_id)->update(array('status' => 'Completed'));

            // Update pmr comments and set to COMPLIED
            Sp_pmr_logs::where('pmr_id',$rq->id)->update(array('status' => 'Complied'));
            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function pmr_delete_lot(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            // delete pmr table
            Sp_pmr::where('id',$rq->id)->delete();

            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function set_pmr_comments_to_complied(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            // Update pmr table
            Sp_pmr_logs::where('id',$rq->id)->update(array('status' => 'Complied'));

            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

}

