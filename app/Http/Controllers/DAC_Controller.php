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
use App\Files;
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

class DAC_Controller extends Controller
{
    public function index(){
        return view('user_dac.home');
    }

    // public function show_modality(Request $rq){
    //     return view('user_dac.modality');
    // }

    public function fetch_modality(Request $rq){
        ob_start('ob_gzhandler');

            // Get modality where user is asigned
            $modality = Assigned_sp::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('assigned_grouping');
            // NYS
            // ON-GOING
            // COMPLETED
            // CANCELLED || WAIVED
            // TRANSFERED
            $grouped_status = Assigned_sp::with('Sp')
            ->where('assigned_to',Auth::User()->id)
            ->get()
            ->groupBy('status');

            $sp_ongoing_all_sp_logs = Assigned_sp::with('Sp')
            ->with(['Sp.Sp_logs' => function($query){
                $query->orderBy('sp_logs_planned', 'ASC')->get();
            }])
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            // ->where('status','On-going')
            ->where('assigned_grouping',$modality[0]->assigned_grouping)
            ->where('assigned_to',Auth::User()->id)
            ->orderBy('updated_at', 'asc')
            ->get();

            $sp_count_groupby_modality = Assigned_sp::where('assigned_to',Auth::User()->id)->get()->groupBy('assigned_grouping');
            // WEIGHTED PERCENTAGE
            // Get all SP
            $sp_arr = [];
            foreach ($sp_ongoing_all_sp_logs as $key) {
                array_push($sp_arr, $key->sp_id);
            }

            $sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')
            ->with(['Sp_logs' => function($x){
                $x->whereNotNull('sp_logs_actual')->orderBy('id','desc')->get();
            }])
            ->whereIn('sp_status',['On-going','Completed'])
            ->whereIn('sp_id',$sp_arr)
            ->get();

            if(sizeof($sp_data) > 0){
                $ddd = Sp_logs::select('sp_id','sp_logs_actual')->with(['Sp' => function($aa){
                    $aa->with(['Assigned_grouping' => function($uu){
                        $uu->where('assigned_to',Auth::User()->id)->whereNotNull('assigned_to')->get();
                    }])->get();
                }])->whereIn('sp_id',$sp_data)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

                if(sizeof($ddd) > 0){

                    $sp_cost_data = [];
                    foreach ($ddd as $key) {
                        foreach ($key as $xx) {
                            array_push($sp_cost_data,  $xx->sp->sp_project_cost);
                        }
                    }
                    $sp_cost_data =  array_values(array_unique($sp_cost_data));
                    $sp_cost = array_sum($sp_cost_data);


                    // Actual Percentage
                    $sp_logs_data = Sp_logs::select('sp_id','sp_logs_actual')->whereIn('sp_id',$sp_data)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

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
                    // end Actual Percentage

                    $c = array_map(function (...$arrays) {
                        return array_product($arrays);
                    }, $per_spid_per_actual, $sp_cost_data);
                    
                    $actual_weighted = (array_sum($c) / $sp_cost);
                    
                }else{
                    $actual_weighted = 0;
                }

            }else{
                $actual_weighted = 0;
            }
            // WEIGHTED PERCENTAGE
            return [$modality,$grouped_status,$sp_ongoing_all_sp_logs,$actual_weighted,$sp_count_groupby_modality];

            // return [$modality,$sp_ongoing,$sp_ongoing_all_sp_logs,$Completed,$sp_nys,$actual_weighted];
        ob_end_flush();
    }

    // MODALITY PAGE
    public function fetch_subprojects(Request $rq){
        ob_start('ob_gzhandler');
            // Get modality where user is asigned
            $modality = Assigned_sp::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('assigned_grouping');

            $subprojects = Assigned_sp::with('Sp')
            ->with(['Sp.Sp_logs' => function($query){
                return $query->whereNotNull('sp_logs_actual')->orderBy('id')->get();
            }])
            ->with('Sp.Sp_pmr')
            ->with('Sp.Sp_pmr.Sp_pmr_logs')
            ->with('Sp.Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            ->where('assigned_grouping',$modality[0]->assigned_grouping)
            ->with('Sp.CMFS_kalahi_2015_BUB_SP')
            ->with('Sp.CMFS_kalahi_2016_BUB_SP')
            ->with('Sp.CMFS_kalahi_2017_BUB_SP')
            ->with('Sp.CMFS_kalahi_2018_BUB_SP')
            ->with('Sp.CMFS_kalahi_2020_BUB_SP')
            ->with('Sp.CMFS_kalahi_2015_BUB_RFR')
            ->with('Sp.CMFS_kalahi_2016_BUB_RFR')
            ->with('Sp.CMFS_kalahi_2017_BUB_RFR')
            ->with('Sp.CMFS_kalahi_2018_BUB_RFR')
            ->with('Sp.CMFS_kalahi_2020_BUB_RFR')
            ->with('Sp.CMFS_kalahi_2015_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2016_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2017_NCDDP_SP')
            // ->with('Sp.CMFS_kalahi_2018_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2019_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2020_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2015_NCDDP_RFR')
            ->with('Sp.CMFS_kalahi_2016_NCDDP_RFR')
            ->with('Sp.CMFS_kalahi_2017_NCDDP_RFR')
            ->with('Sp.CMFS_kalahi_2018_NCDDP_RFR')
            ->with('Sp.CMFS_kalahi_2019_NCDDP_RFR')
            ->with('Sp.CMFS_kalahi_2020_NCDDP_RFR')
            ->where('assigned_to',Auth::User()->id)
            ->orderBy('updated_at','desc')
            ->paginate(100);

            return $subprojects;
        ob_end_flush();
    }

    public function fetch_reports_modality(Request $rq){
        ob_start('ob_gzhandler');

            $sp = Assigned_sp::with('Sp')
            ->with('Sp.Sp_logs')
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            ->with('Sp_pmr.Sp_pmr_logs')
            ->with('Sp_pmr.Sp_pmr_remarks_logs')
            ->with('Sp.Sp_batch')
            ->with('Sp.Sp_cycle')
            // ->with(['Users' => function($query){
            //    $query->select('id','Fname','Lname')->get();
            // }])
            ->where('assigned_to',Auth::User()->id)
            ->get();

            return $sp;
        ob_end_flush();
    }

    public function fetch_dac_modality_sp(Request $rq){
        ob_start('ob_gzhandler');
            // SELECT ALL MODALITY ASSIGNED TO USER ACCOUNT THEN FILTER ALL SP THAT IS ASSIGNED TO USER DEPENDING ON TYPE OF MODALITY THAT IS BEING CLICKED
            if($rq->modality == 1 || $rq->modality == 2 || $rq->modality == 4 || $rq->modality == 5 || $rq->modality == 6){

                $sp_ongoing = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with(['Sp_logs' => function($query){
                        // return $query->whereNull('sp_logs_actual')->latest()->first();
                       return $query->whereNull('sp_logs_actual')->get();
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
                    ->where('sp_status','On-going')
                    ->get();
                }])
                ->with(['Users' => function($query){
                   $query->select('id')->with('Files')->get();
                }])
                ->where('status','On-going')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                $sp_nys = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with(['Sp_logs' => function($query){
                       $query->where('sp_logs_actual',null)->limit(1)->get();
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
                    ->where('sp_status','NYS')
                    ->get();
                }])
                ->with(['Users' => function($query){
                   $query->select('id')->with('Files')->get();
                }])
                ->where('status','NYS')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                $sp_completed = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with('Sp_logs')
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
                    ->where('sp_status','Completed')
                    ->get();
                }])
                ->where('status','Completed')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                $sp_ongoing_all_sp_logs = Assigned_sp::with('Sp')
                ->with(['Sp.Sp_logs' => function($query){
                   $query->where('sp_logs_actual','<>',null)->get();
                }])
                ->with('Sp.Sp_groupings')
                ->where('status','On-going')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                return [$sp_ongoing,$sp_completed,$sp_ongoing_all_sp_logs,$sp_nys];

            }else{


                $sp_ongoing = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with(['Sp_logs' => function($query){
                        $query->whereNull('sp_logs_actual')->get();
                    }])
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
                    ->where('sp_status','On-going');
                }])
                ->with(['Users' => function($query){
                   $query->select('id')->with('Files')->get();
                }])
                ->where('status','On-going')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                $sp_nys = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with(['Sp_logs' => function($query){
                       $query->where('sp_logs_actual',null)->limit(1)->get();
                    }])
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
                    ->where('sp_status','NYS')
                    ->get();
                }])
                ->with(['Users' => function($query){
                   $query->select('id')->with('Files')->get();
                }])
                ->where('status','NYS')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                $sp_completed = Assigned_sp::with(['Sp' => function($query){
                    $query
                    ->with('Sp_groupings')
                    ->with('Sp_category')
                    ->with('Sp_type')
                    ->with('Sp_pmr.Sp_pmr_logs')
                    ->with('Sp_pmr.Sp_pmr_remarks_logs')
                    ->with('Sp_logs')
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
                    ->where('sp_status','Completed')
                    ->get();
                }])
                ->where('status','Completed')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);
                // return $sp_completed;

                $sp_ongoing_all_sp_logs = Assigned_sp::with('Sp')
                ->with(['Sp.Sp_logs' => function($query){
                   $query->where('sp_logs_actual','<>',null)->get();
                }])
                ->with('Sp.Sp_groupings')
                // ->withCount('Sp_logs')
                ->where('status','On-going')
                ->where('assigned_grouping',$rq->modality)
                ->where('assigned_to',Auth::User()->id)
                ->paginate(30);

                return [$sp_ongoing,$sp_completed,$sp_ongoing_all_sp_logs,$sp_nys];
            }
        ob_end_flush();
    }

    public function fetch_specific_modality_sp_logs_length(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->whereNull('sp_logs_actual')->orderBy('id')->get();
        ob_end_flush();
    }

    public function view_planned_sched(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->orderBy('sp_logs_planned_target_date')->get();
        ob_end_flush();
    }

    public function update_subproject_data(Request $rq){
        ob_start('ob_gzhandler');

        DB::beginTransaction();
        try {

            $current_planned = Sp_logs::select('id','sp_logs_planned')->where('id', $rq->logs_id)->get();

            Sp_logs::where('id', $rq->logs_id)->update(array('sp_logs_actual' => $rq->act,'sp_logs_slippage' => $rq->slippage, 'sp_logs_issues' => $rq->iss_prob,'sp_logs_analysis' => $rq->analysis,'sp_logs_remarks' => $rq->remarks));

            Sp::where('sp_id', $rq->sp_id)->update(array('updated_at' => date("Y-m-d"), 'planned' => $current_planned[0]->sp_logs_planned, 'actual' => $rq->act, 'slippage' => $rq->slippage, 'issues' => $rq->iss_prob, 'analysis' => $rq->analysis, 'remarks' => $rq->remarks));

            if($rq->act == 100 || $rq->act == '100'){
                Sp::where('sp_id', $rq->sp_id)->update(array('sp_status' => 'Completed'));
                Assigned_sp::where('sp_id', $rq->sp_id)->update(array('status' => 'Completed'));
            }

            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // return "error";
            return $e->getMessage();
        }

        ob_end_flush();
        // return "success";
    }

    public function updating_sp_single_data(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                Sp::where('sp_id', $rq->sp_id)->update(array($rq->updated_field => $rq->updated_field_value));
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

    // public function show_file(Request $rq){
    //     return view('user_dac.upload');
    // }

    public function upload_file(Request $rq){
        ob_start('ob_gzhandler');
        try {

            foreach ($rq->file as $key) {
                $name = $key->getClientOriginalName();
                $user_folder = Auth::User()->username;
                // return $rq->category;
                $addnew = new Files;
                $addnew->filename = $name;
                $addnew->origin = Auth::User()->id;
                $addnew->category = $rq->category;
                $addnew->sp_id = $rq->sp_id;
                Storage::disk("public")->put("profile/DAC/$user_folder/$rq->category/$name",file_get_contents($key));
                $addnew->path = "profile/DAC/$user_folder/$rq->category/$name";
                $addnew->save();

                $file_id = Files::where('sp_id',$rq->sp_id)->where('path',"profile/DAC/$user_folder/$rq->category/$name")->get();

                if ($rq->category == 'SP_files_BP') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_building_permit' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_FP') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_fullblown_proposal' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_VO') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_variation_order' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_MT') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_mt' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_EMSR') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_esmr' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_CSR') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_csr' => $file_id[0]->id));
                } elseif ($rq->category == 'SP_files_SPCR') {
                    Sp::where('sp_id', $rq->sp_id)->update(array('sp_spcr' => $file_id[0]->id));
                } else;

            }
            
            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e->getMessage();
        }

        // if not SP Files

        ob_end_flush();
    }

    public function delete_file(Request $rq){
        ob_start('ob_gzhandler');
        try {

            // Delete file
            $user_folder = Auth::User()->username;
            $path = Files::where('id', $rq->file_id)->get();
            // return $path[0]->path;
            // Delete file table
            Files::where('id',$rq->file_id)->delete();
            Storage::disk('public')->delete($path[0]->path);

            DB::commit();
            return 1;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e->getMessage();
        }
        // if not SP Files
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
    
    public function download(Request $rq){
        ob_start('ob_gzhandler');
            $path = Files::select('path')->where('origin',Auth::User()->id)->where('id', $rq->id)->get();
            // return $path[0]->path;
            // return Files::select('path')->where('origin',Auth::User()->id)->where('id', $rq->id)->get();

            // $file = Storage::disk("public")->get($path[0]->path);
            return Storage::disk("public")->download($path[0]->path);
        ob_end_flush();
    }

    public function profile(){
        return view('user_dac.profile');
    }

    public function create_pmr(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                $addnew = new Sp_pmr;
                $addnew->sp_id = $rq->sp_id;
                $addnew->mode_of_procurement = $rq->mode_of_procurement;
                $addnew->code = $rq->code;
                $addnew->nature_of_procurement = $rq->nature_of_procurement;
                $addnew->fund_source = $rq->fund_source;
                $addnew->apa_pre_proc_con = $rq->apa_pre_proc_con;
                $addnew->apa_ads = $rq->apa_ads;
                $addnew->apa_prebid_con = $rq->apa_prebid_con;
                $addnew->apa_eligibility_check = $rq->apa_eligibility_check;
                $addnew->apa_open_of_bids = $rq->apa_open_of_bids;
                $addnew->apa_bid_eval = $rq->apa_bid_eval;
                $addnew->apa_post_qual = $rq->apa_post_qual;
                $addnew->bac_reso_recom_award = $rq->bac_reso_recom_award;
                $addnew->apa_notice_of_award = $rq->apa_notice_of_award;
                $addnew->apa_contract_signing = $rq->apa_contract_signing;
                $addnew->apa_notice_to_proceed = $rq->apa_notice_to_proceed;
                $addnew->apa_contract_review_date = $rq->apa_contract_review_date;
                $addnew->apa_target_date_completion = $rq->apa_target_date_completion;
                $addnew->apa_delivery = $rq->apa_delivery;
                $addnew->apa_acceptance = $rq->apa_acceptance;
                $addnew->apa_contractors_eval_conducted = $rq->apa_contractors_eval_conducted;
                $addnew->delivery_percentage = $rq->delivery_percentage;
                $addnew->early_procurement_activity = $rq->early_procurement_activity;
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

    public function update_pmr(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();
            try {
                Sp_pmr::where('id', $rq->id)->update(array('mode_of_procurement' => $rq->mode_of_procurement, 'code' => $rq->code, 'fund_source' => $rq->fund_source, 'abc_total' => $rq->abc_total, 'abc_mooe' => $rq->abc_mooe, 'abc_co' => $rq->abc_co, 'contract_cost_total' => $rq->contract_cost_total, 'contract_cost_mooe' => $rq->contract_cost_mooe, 'contract_cost_co' => $rq->contract_cost_co));
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

    public function pmr_update_single_data(Request $rq){
        ob_start('ob_gzhandler');
            DB::beginTransaction();

            try {
                Sp_pmr::where('id', $rq->id)->update(array($rq->updated_field => $rq->date, 'delivery_percentage' => $rq->delivery_percentage));

                $addnew = new Sp_pmr_remarks_logs;
                $addnew->pmr_id = $rq->id;
                $addnew->updated_field = $rq->updated_field;
                $addnew->pmr_remarks = $rq->remarks;
                $addnew->delivery_percentage = $rq->delivery_percentage;
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
}
