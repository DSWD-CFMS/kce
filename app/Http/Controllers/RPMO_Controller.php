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

use App\Sp;
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

// // CMFS 2015
use App\CMFS_kalahi_2015_NCDDP_SP;
use App\CMFS_kalahi_2015_BUB_SP;

use App\CMFS_kalahi_2015_BUB_RFR;
use App\CMFS_kalahi_2015_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2015_NCDDP_RFR;
use App\CMFS_kalahi_2015_NCDDP_RFR_FINDINGS;

use App\CMFS_kalahi_2015_BUB_SPCR;
use App\CMFS_kalahi_2015_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2015_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2015_NCDDP_SPCR;
use App\CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2015_NCDDP_SPCR_LOGS;
// // CMFS 2015

// // CMFS 2016
use App\CMFS_kalahi_2016_NCDDP_SP;
use App\CMFS_kalahi_2016_BUB_SP;

use App\CMFS_kalahi_2016_BUB_RFR;
use App\CMFS_kalahi_2016_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2016_NCDDP_RFR;
use App\CMFS_kalahi_2016_NCDDP_RFR_FINDINGS;

use App\CMFS_kalahi_2016_BUB_SPCR;
use App\CMFS_kalahi_2016_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2016_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2016_NCDDP_SPCR;
use App\CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2016_NCDDP_SPCR_LOGS;

// // CMFS 2016

// // CMFS 2017
use App\CMFS_kalahi_2017_NCDDP_SP;
use App\CMFS_kalahi_2017_BUB_SP;

use App\CMFS_kalahi_2017_BUB_RFR;
use App\CMFS_kalahi_2017_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2017_NCDDP_RFR;
use App\CMFS_kalahi_2017_NCDDP_RFR_FINDINGS;

use App\CMFS_kalahi_2017_BUB_SPCR;
use App\CMFS_kalahi_2017_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2017_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2017_NCDDP_SPCR;
use App\CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2017_NCDDP_SPCR_LOGS;
// // CMFS 2017


// // CMFS 2018
use App\CMFS_kalahi_2018_NCDDP_SP;
use App\CMFS_kalahi_2018_BUB_SP;

use App\CMFS_kalahi_2018_BUB_RFR;
use App\CMFS_kalahi_2018_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2018_NCDDP_RFR;
use App\CMFS_kalahi_2018_NCDDP_RFR_FINDINGS;

use App\CMFS_kalahi_2018_BUB_SPCR;
use App\CMFS_kalahi_2018_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2018_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2018_NCDDP_SPCR;
use App\CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2018_NCDDP_SPCR_LOGS;
// // CMFS 2018

// // CMFS 2019
use App\CMFS_kalahi_2019_NCDDP_SP;
use App\CMFS_kalahi_2019_BUB_SP;

use App\CMFS_kalahi_2019_NCDDP_RFR;
use App\CMFS_kalahi_2019_NCDDP_RFR_FINDINGS;
use App\CMFS_kalahi_2019_BUB_RFR;
use App\CMFS_kalahi_2019_BUB_RFR_FINDINGS;

use App\CMFS_kalahi_2019_BUB_SPCR;
use App\CMFS_kalahi_2019_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2019_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2019_NCDDP_SPCR;
use App\CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2019_NCDDP_SPCR_LOGS;
// // CMFS 2019

// // CMFS 2020
use App\CMFS_kalahi_2020_NCDDP_SP;
use App\CMFS_kalahi_2020_BUB_SP;

use App\CMFS_kalahi_2020_BUB_SPCR;
use App\CMFS_kalahi_2020_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2020_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2020_NCDDP_SPCR;
use App\CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2020_NCDDP_SPCR_LOGS;

use App\CMFS_kalahi_2020_BUB_RFR;
use App\CMFS_kalahi_2020_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2020_NCDDP_RFR;
use App\CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
// // CMFS 2020

// // CMFS 2021
use App\CMFS_kalahi_2021_NCDDP_SP;
use App\CMFS_kalahi_2021_BUB_SP;

use App\CMFS_kalahi_2021_BUB_SPCR;
use App\CMFS_kalahi_2021_BUB_SPCR_FINDINGS;
use App\CMFS_kalahi_2021_BUB_SPCR_LOGS;
use App\CMFS_kalahi_2021_NCDDP_SPCR;
use App\CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS;
use App\CMFS_kalahi_2021_NCDDP_SPCR_LOGS;

use App\CMFS_kalahi_2021_BUB_RFR;
use App\CMFS_kalahi_2021_BUB_RFR_FINDINGS;
use App\CMFS_kalahi_2021_NCDDP_RFR;
use App\CMFS_kalahi_2021_NCDDP_RFR_FINDINGS;
// // CMFS 2021

class RPMO_Controller extends Controller
{
    public function index(){
        return view('user_rpmo.home');
    }

    public function new_module(){
        return view('user_rpmo.home');
    }   

    public function new_module_content(){
        return view('user_rpmo.new_module');
    } 
    
    public function new_module_content_table(){
        $string = "<div class='table-responsive'><table class='display dataTable no-footer' id='table_details' cellspacing='0' width='100%'>
        <thead>
        <tr>
        <th>#</th>
        <th>Barangay</th>
        <th>SPID</th>
        <th>Title</th>
        <th>Modality</th>
        <th>Planned</th>
        <th>Actual</th>
        <th>Slippage</th>
        <th>DAC</th>
        <th>Status</th>
        <th>Action</th></tr></thead><tbody>";

       
        $results = DB::select( DB::raw("SELECT
                sp_brgy,
                sp.sp_id as sp_id,
                sp_title,
                sp_groupings.grouping as modality,
                planned,
                actual,
                slippage,
                sp_status,
                CONCAT(Lname,', ',Fname) as name
            FROM
                sp,
                sp_groupings,
                assigned_sp,
                users
            WHERE sp.sp_groupings = sp_groupings.id
            AND sp.sp_id = assigned_sp.sp_id
            AND assigned_sp.assigned_to = users.id
            ORDER BY
                sp.id DESC") );
                
        $count = 0;
        foreach($results as $row){
           $string .= "<tr>";
            $string .= "<td>".(++$count)."</td>";
            $string .= "<td>".$row->sp_brgy."</td>";
            $string .= "<td>".$row->sp_id."</td>";
            $string .= "<td>".$row->sp_title."</td>";
            $string .= "<td>".$row->modality."</td>";
            $string .= "<td>".$row->planned."</td>";
            $string .= "<td>".$row->actual."</td>";
            $string .= "<td>".$row->slippage."</td>";
            $string .= "<td>".$row->name."</td>";
            $string .= "<td>".$row->sp_status."</td>";
            $string .= `<td><button class='btn btn-success btn-xs' onclick="det_modal()">More</button></td>`;
           $string .= "</tr>";
        }

        $string .= "</tbody></table></div>";

        return $string;
    } 

    public function iTextMoAPI($number,$message,$apicode,$passwd){
        //##########################################################################
        // ITEXMO SEND SMS API - PHP - CURL METHOD
        // Visit www.itexmo.com/developers.php for more info about this API
        //##########################################################################
            $ch = curl_init();
            $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
            curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, 
                      http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            return curl_exec ($ch);
            curl_close ($ch);
        //##########################################################################
    }

    public function update_sp_status(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {

            if($rq->type == 'On-going'){
            // // UPDATE ASSIGNED SP
                Assigned_sp::where('sp_id', $rq->sp_id)->update(array('status' => $rq->type));
                Sp::where('sp_id', $rq->sp_id)->update(array('sp_status' => $rq->type, 'sp_date_started' => $rq->date_started));
            }else if($rq->type == 'Completed'){
                Assigned_sp::where('sp_id', $rq->sp_id)->update(array('status' => 'Completed'));
                Sp::where('sp_id', $rq->sp_id)->update(array('sp_status' => 'Completed', 'sp_actual_date_completed' => $rq->date_of_completion));
            }else;

            // $rpmo_focal = Users::select('Fname','Lname','contact')->where('id',Auth::User()->id)->get();
            // $assigned_to = Assigned_sp::select('assigned_to')->where('sp_id', $rq->sp_id)->get();

            // $dac = Users::select('Fname','Lname','contact')->where('id',$assigned_to[0]->assigned_to)->get();
            // $sp_data = Sp::where('sp_id',$rq->sp_id)->get();

            // $text_data = "SP: ". $sp_data[0]->sp_id. " at ". $sp_data[0]->sp_brgy. ", ". $sp_data[0]->sp_municipality. ", ". $sp_data[0]->sp_province . " | Updated as COMPLETED - " . $rpmo_focal[0]->Fname .' '. $rpmo_focal[0]->Lname;;

            // // $contact_rcis_testing = '+639568625630';
            // $contact_rcis = '+639568625630';
            // $phonearray = [$contact_rcis,$dac[0]->contact,$rpmo_focal[0]->contact];

            // // UPDATE ASSIGNED SP
            // Assigned_sp::where('sp_id', $rq->sp_id)->update(array('status' => 'Completed'));
            // Sp::where('sp_id', $rq->sp_id)->update(array('sp_status' => 'Completed', 'sp_actual_date_completed' => $rq->date_of_completion));
            
            // $ApiCode = "TR-KCEWE010080_5XMEM";
            // $ApiPassword = "g9)&bc8]7]";
            
            // for($z = 0; $z < sizeof($phonearray); $z++){
            //     $this->iTextMoAPI($phonearray[$z],$text_data,$ApiCode,$ApiPassword);
            // }

            DB::commit();
            return 1;
            // return ['success',$text_data,$rpmo_focal,$dac,$contact_rcis];
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function fetch_modality(Request $rq){
        // Get modality where user is asigned
        $modality = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('sp_grouping_id');
        
        $groupings_sp = Assigned_grouping::with(['Sp' => function($query1){
           $query1->with('Sp_type')
            ->with('Sp_category')
            ->with('Sp_groupings')
            ->with(['Sp_logs' => function($query){
                // $query->get();
                $query->whereNotNull('sp_logs_actual')->get();
            }])->where('sp_status','On-going')->orderBy('updated_at', 'desc')->limit(1)->get();
        }])
        ->where('assigned_to',Auth::User()->id)
        ->get();

        // ON GOING
        $Count_Ongoing_sp_data = Assigned_grouping::with(['Sp' => function($query1){
           $query1->where('sp_status','On-going')->get();
        }])
        ->where('assigned_to',Auth::User()->id)
        ->get();

        $Count_Ongoing_sp = $Count_Ongoing_sp_data->map(function ($item, $key) {
            return $item->sp->whereIn('sp_status', 'On-going')->count();
        })->sum();
        // ON GOING

        // NYS
        $Count_NYS_sp_data = Assigned_grouping::with(['Sp' => function($query1){
           $query1->where('sp_status','NYS')->get();
        }])
        ->where('assigned_to',Auth::User()->id)
        ->get();

        $Count_NYS_sp = $Count_NYS_sp_data->map(function ($item, $key) {
            return $item->sp->whereIn('sp_status', 'NYS')->count();
        })->sum();
        // NYS

        // COMPLETED
        $Count_Completed_sp_data = Assigned_grouping::with(['Sp' => function($query1){
           return $query1->where('sp_status','Completed')->count();
        }])
        ->where('assigned_to',Auth::User()->id)
        ->get();

        $Count_Completed_sp = $Count_Completed_sp_data->map(function ($item, $key) {
            return $item->sp->whereIn('sp_status', 'Completed')->count();
        })->sum();
        // COMPLETED

        // WEIGHTED PERCENTAGE
        $modality_arr = [];
        foreach ($modality as $key) {
            array_push($modality_arr, $key->sp_grouping_id);
        }
        $sp_data = Sp::select('sp_id','sp_groupings','sp_project_cost')->with(['Assigned_grouping' => function($q){
            $q->select('sp_grouping_id','assigned_to')->where('assigned_to',Auth::User()->id)->get();
        }])
        ->with(['Sp_logs' => function($x){
            $x->whereNotNull('sp_logs_actual')->orderBy('id','desc')->get();
        }])
        ->where('sp_status','On-going')
        // ->where('sp_status','Completed')
        ->whereIn('sp_groupings',$modality_arr)
        ->get();

        if(sizeof($sp_data) > 0){
            $sp_id = [];
            foreach ($sp_data as $key) {
                array_push($sp_id, $key->sp_id);
            }

            $ddd = Sp_logs::select('sp_id','sp_logs_actual')->with(['Sp' => function($aa){
                $aa->with(['Assigned_grouping' => function($uu){
                    $uu->where('assigned_to',Auth::User()->id)->whereNotNull('assigned_to')->get();
                }])->get();
            }])->whereIn('sp_id',$sp_id)->whereNotNull('sp_logs_actual')->get()->groupBy('sp_id');

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
            // end Actual Percentage

            $c = array_map(function (...$arrays) {
                return array_product($arrays);
            }, $per_spid_per_actual, $sp_cost_data);

            // $actual_weighted = (array_sum($c) / $sp_cost);
            if($sp_cost == 0){
                $actual_weighted = (array_sum($c) / 1);
            }else{
                $actual_weighted = (array_sum($c) / $sp_cost);
            }
        }else{
            $actual_weighted = 0;
        }
        // WEIGHTED PERCENTAGE
        return [$modality,$groupings_sp,$Count_Ongoing_sp,$Count_Completed_sp,round($actual_weighted,2),$Count_NYS_sp];
    }

    public function show_modality(Request $rq){
        return view('user_rpmo.modality');
    }
    
    public function fetch_rpmo_sps(Request $rq){
        $modality = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('sp_grouping_id');

   
        $modality_array = [];
        foreach ($modality as $key) {
            array_push($modality_array, $key->sp_grouping_id);
        }
        
        return Sp::with(['Sp_logs' => function($query){
           $query->where('sp_logs_actual','<>',null)->get();
        }])
        ->with(['Assigned_sp' => function($query){
            $query->with(['Users' => function($ee){
                return $ee->select('id','Fname','Lname')->get();
            }])->get();
        }])
        // ->with('Cadt')
        ->with(['Sp_groupings' => function($query){
            $query->select('id','grouping')->get();
        }])
        // ->with(['Sp_category' => function($query){
        //     $query->select('id','category')->get();
        // }])
        // ->with(['Sp_type' => function($query){
        //     $query->select('id','type')->get();
        // }])
        // ->whereIn('sp_status', ['Completed','On-going','NYS'])
        // ->whereIn('sp_groupings',$modality_array)
        ->orderBy('updated_at','DESC')
        ->paginate(100);

        // ->with(['Users' => function($e){
        //     $e->select('id','Fname','Lname')->get();
        // }])
        // ->with(['Sp.Assigned_grouping' => function($query){
        //     $query->where('assigned_to',Auth::User()->id);
        // }])
        // ->with(['Sp.Sp_logs' => function($query){
        //    $query->whereNotNull('sp_logs_actual')->get();
        // }])
        // ->with('Sp.Cadt')
        // ->with('Sp.Sp_groupings')
    }

    public function fetch_rpmo_modality_sp(Request $rq){
        // SELECT ALL MODALITY ASSIGNED TO USER ACCOUNT THEN FILTER ALL SP THAT IS ASSIGNED TO USER DEPENDING ON TYPE OF MODALITY THAT IS BEING CLICKED
        if($rq->modality == 1 || $rq->modality == 2 || $rq->modality == 4 || $rq->modality == 5 || $rq->modality == 6){
            $sp_ongoing = Assigned_sp::with(['Sp' => function($query){
               $query
                ->with(['Sp_logs' => function($query){
                   $query->where('sp_logs_actual',null)->limit(1)->get();
                }])
                ->with(['Assigned_grouping' => function($query){
                    $query->where('assigned_to',Auth::User()->id);
                }])
                ->with('Cadt')
                ->with('Sp_groupings')
                ->with('Sp_category')
                ->with('Sp_type')
                ->with('CMFS_kalahi_2015_BUB_SP')
                ->with('CMFS_kalahi_2016_BUB_SP')
                ->with('CMFS_kalahi_2017_BUB_SP')
                ->with('CMFS_kalahi_2018_BUB_SP')
                ->with('CMFS_kalahi_2020_BUB_SP')
                ->with('CMFS_kalahi_2021_BUB_SP')
               ->where('sp_status','On-going')
               ->get();
            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->where('status','On-going')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_completed = Assigned_sp::with(['Sp' => function($query){
               $query
                ->with(['Sp_logs' => function($query){
                   // $query->where('sp_logs_actual',null)->limit(1)->get();
                }])
                ->with(['Assigned_grouping' => function($query){
                    $query->where('assigned_to',Auth::User()->id);
                }])
                ->with('Cadt')
                ->with('Sp_groupings')
                ->with('Sp_category')
                ->with('Sp_type')
                ->with('CMFS_kalahi_2015_BUB_SP')
                ->with('CMFS_kalahi_2016_BUB_SP')
                ->with('CMFS_kalahi_2017_BUB_SP')
                ->with('CMFS_kalahi_2018_BUB_SP')
                ->with('CMFS_kalahi_2020_BUB_SP')
                ->with('CMFS_kalahi_2021_BUB_SP')
                ->where('sp_status','Completed')
                ->orderBy('sp_id', 'ASC')
                ->get();
            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->where('status','Completed')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_ongoing_all_sp_logs = Assigned_sp::with('Sp')
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Sp.Assigned_grouping' => function($query){
                $query->where('assigned_to',Auth::User()->id);
            }])
            ->with(['Sp.Sp_logs' => function($query){
               $query->whereNotNull('sp_logs_actual')->get();
            }])
            ->with('Sp.Cadt')
            ->with('Sp.Sp_groupings')
            ->where('status','On-going')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_nys = Assigned_sp::with(['Sp' => function($query){
                $query
                ->with(['Sp_logs' => function($query){
                   $query->where('sp_logs_actual',null)->limit(1)->get();
                }])
                ->with(['Assigned_grouping' => function($query){
                    $query->where('assigned_to',Auth::User()->id);
                }])
                ->with('Cadt')
                ->with('Sp_groupings')
                ->with('Sp_category')
                ->with('Sp_type')
                ->with('CMFS_kalahi_2015_BUB_SP')
                ->with('CMFS_kalahi_2016_BUB_SP')
                ->with('CMFS_kalahi_2017_BUB_SP')
                ->with('CMFS_kalahi_2018_BUB_SP')
                ->with('CMFS_kalahi_2020_BUB_SP')
                ->with('CMFS_kalahi_2021_BUB_SP')
                ->where('sp_status','NYS')
                ->get();

            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->where('status','NYS')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);

            return [$sp_ongoing,$sp_completed,$sp_ongoing_all_sp_logs,$sp_nys];
        
        }else{

            $sp_ongoing = Assigned_sp::with(['Sp' => function($query){
               $query->where('sp_status','On-going')
               ->get();
            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Sp.Sp_logs' => function($query){
               $query->where('sp_logs_actual',null)->limit(1)->get();
            }])
            ->with(['Sp.Assigned_grouping' => function($query){
                $query->where('assigned_to',Auth::User()->id);
            }])
            ->with('Sp.Cadt')
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            ->with('Sp.CMFS_kalahi_2015_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2016_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2017_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2018_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2019_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2020_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2021_NCDDP_SP')
            ->where('status','On-going')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_completed = Assigned_sp::with(['Sp' => function($query){
               $query->where('sp_status','Completed')->get();
            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Sp.Sp_logs' => function($query){
               // $query->where('sp_logs_actual',null)->limit(1)->get();
            }])
            ->with(['Sp.Assigned_grouping' => function($query){
                $query->where('assigned_to',Auth::User()->id);
            }])
            ->with('Sp.Cadt')
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            ->with('Sp.CMFS_kalahi_2015_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2016_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2017_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2018_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2019_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2020_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2021_NCDDP_SP')
            ->where('status','Completed')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_ongoing_all_sp_logs = Assigned_sp::with('Sp')
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Sp.Assigned_grouping' => function($query){
                $query->where('assigned_to',Auth::User()->id);
            }])
            ->with(['Sp.Sp_logs' => function($query){
               $query->whereNotNull('sp_logs_actual')->get();
            }])
            ->with('Sp.Cadt')
            ->with('Sp.Sp_groupings')
            ->where('status','On-going')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);
            // ->get();

            $sp_nys = Assigned_sp::with(['Sp' => function($query){
               $query->where('sp_status','NYS')->get();
            }])
            ->with(['Users' => function($e){
                $e->select('id','Fname','Lname')->get();
            }])
            ->with(['Sp.Sp_logs' => function($query){
               $query->where('sp_logs_actual',null)->limit(1)->get();
            }])
            ->with(['Sp.Assigned_grouping' => function($query){
                $query->where('assigned_to',Auth::User()->id);
            }])
            ->with('Sp.Cadt')
            ->with('Sp.Sp_groupings')
            ->with('Sp.Sp_category')
            ->with('Sp.Sp_type')
            ->with('Sp.CMFS_kalahi_2015_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2016_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2017_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2018_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2019_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2020_NCDDP_SP')
            ->with('Sp.CMFS_kalahi_2021_NCDDP_SP')
            ->where('status','NYS')
            ->where('assigned_grouping',$rq->modality)
            ->paginate(10);

            return [$sp_ongoing,$sp_completed,$sp_ongoing_all_sp_logs,$sp_nys];

        }
    }

    public function view_planned_sched(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->get();
        ob_end_flush();
    }
    
    public function fetch_specific_modality_sp_logs_length(Request $rq){
        ob_start('ob_gzhandler');
            return Sp_logs::where('sp_id',$rq->sp_id)->get()->count();
        ob_end_flush();
    }

    public function fetch_all_for_export(Request $rq){
        $assigned_grouping_data = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get();
        $assigned_grouping_array = [];
        foreach ($assigned_grouping_data as $key) {
            array_push($assigned_grouping_array,$key->sp_grouping_id);
        }

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
    
    public function show_reports(Request $rq){
        return view('user_rpmo.reports');
    }

    public function fetch_reports_modality(Request $rq){
        // Check if as na belong nga sp_groupings
        $assigned_grouping_data = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get();
        $assigned_grouping_array = [];
        foreach ($assigned_grouping_data as $key) {
            array_push($assigned_grouping_array,$key->sp_grouping_id);
        }

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
        ->with('CMFS_kalahi_2021_BUB_SP')
        ->with('CMFS_kalahi_2015_BUB_RFR')
        ->with('CMFS_kalahi_2016_BUB_RFR')
        ->with('CMFS_kalahi_2017_BUB_RFR')
        ->with('CMFS_kalahi_2018_BUB_RFR')
        ->with('CMFS_kalahi_2020_BUB_RFR')
        ->with('CMFS_kalahi_2021_BUB_RFR')
        ->with('CMFS_kalahi_2015_NCDDP_SP')
        ->with('CMFS_kalahi_2016_NCDDP_SP')
        ->with('CMFS_kalahi_2017_NCDDP_SP')
        // ->with('CMFS_kalahi_2018_NCDDP_SP')
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
        
        return [$sp_ongoing_all_sp_logs,$assigned_grouping_data];
    }

    public function show_file(Request $rq){
        return view('user_rpmo.upload');
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
            Storage::disk("public")->put("profile/RPMO/$user_folder/$rq->category/$name",file_get_contents($key));
            $addnew->path = "profile/RPMO/$user_folder/$rq->category/$name";
            $addnew->save();
        }
        return "success";
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
            $path = Files::select('path')->where('origin',Auth::User()->id)->where('id', $rq->path)->get();
            // $file = Storage::disk("public")->get($path[0]->path);
            return Storage::disk("public")->download($path[0]->path);
        ob_end_flush();
    }

    public function download_sp_files(Request $rq){
        ob_start('ob_gzhandler');
            $path = Files::select('path')->where('origin',Auth::User()->id)->where('filename', $rq->path)->get();
            return Storage::disk("public")->download($path[0]->path);
        ob_end_flush();
    }

    public function delete_file(Request $rq){
        ob_start('ob_gzhandler');
        try {

            // Delete file
            $user_folder = Auth::User()->username;
            $path = Files::where('id', $rq->file_id)->get();
            // return Sp::where('sp_id',$path[0]->sp_id)->get();
            Storage::disk('public')->deleteDirectory("profile/DAC/".$user_folder."/".$path[0]->category."/".$path[0]->filename);


            // Update SP file
            // return Files::where('sp_id', $path[0]->sp_id)->orderBy('created_at','desc')->get();
            // Delete file table
            Files::where('id',$rq->file_id)->delete();

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

}
