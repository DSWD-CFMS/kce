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
use Carbon\Carbon;

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

class CMFS_Controller extends Controller
{
    public function fetch_rfr(Request $rq){

    	if($rq->sp_groupings == 1 || $rq->sp_groupings == 2 || $rq->sp_groupings == 4 || $rq->sp_groupings == 5 || $rq->sp_groupings == 6){
	    	$data = Sp::with(['CMFS_kalahi_2015_BUB_RFR.CMFS_kalahi_2015_BUB_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2016_BUB_RFR.CMFS_kalahi_2016_BUB_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2017_BUB_RFR.CMFS_kalahi_2017_BUB_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2018_BUB_RFR.CMFS_kalahi_2018_BUB_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2020_BUB_RFR.CMFS_kalahi_2020_BUB_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with('CMFS_kalahi_2016_BUB_SP')
                ->with('CMFS_kalahi_2017_BUB_SP')
                ->with('CMFS_kalahi_2018_BUB_SP')
                ->with('CMFS_kalahi_2020_BUB_SP')
				->where('sp_id', $rq->sp_id)
				->get();

			if($data[0]->CMFS_kalahi_2015_BUB_RFR != null){
				return [$data,$data[0]->CMFS_kalahi_2015_BUB_RFR->CMFS_kalahi_2015_BUB_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2016_BUB_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2016_BUB_RFR->CMFS_kalahi_2016_BUB_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2017_BUB_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2017_BUB_RFR->CMFS_kalahi_2017_BUB_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2018_BUB_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2018_BUB_RFR->CMFS_kalahi_2018_BUB_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2020_BUB_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2020_BUB_RFR->CMFS_kalahi_2020_BUB_RFR_FINDINGS->groupBy('department')];
			}else{
				return $data;
			};

    	}else{

	    	$data = Sp::with(['CMFS_kalahi_2015_NCDDP_RFR.CMFS_kalahi_2015_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2016_NCDDP_RFR.CMFS_kalahi_2016_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2017_NCDDP_RFR.CMFS_kalahi_2017_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2018_NCDDP_RFR.CMFS_kalahi_2018_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2019_NCDDP_RFR.CMFS_kalahi_2019_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->
				with(['CMFS_kalahi_2020_NCDDP_RFR.CMFS_kalahi_2020_NCDDP_RFR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
                ->with('CMFS_kalahi_2015_NCDDP_SP')
                ->with('CMFS_kalahi_2016_NCDDP_SP')
                ->with('CMFS_kalahi_2017_NCDDP_SP')
                ->with('CMFS_kalahi_2018_NCDDP_SP')
                ->with('CMFS_kalahi_2019_NCDDP_SP')
                ->with('CMFS_kalahi_2020_NCDDP_SP')
				->where('sp_id', $rq->sp_id)
				->get();

			if($data[0]->CMFS_kalahi_2015_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2015_NCDDP_RFR->CMFS_kalahi_2015_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2016_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2016_NCDDP_RFR->CMFS_kalahi_2016_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2017_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2017_NCDDP_RFR->CMFS_kalahi_2017_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2018_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2018_NCDDP_RFR->CMFS_kalahi_2018_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2019_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2019_NCDDP_RFR->CMFS_kalahi_2019_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2020_NCDDP_RFR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2020_NCDDP_RFR->CMFS_kalahi_2020_NCDDP_RFR_FINDINGS->groupBy('department')];

			}else{
				return $data;
			};

    	}
    }

    public function submit_rfr_findings(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
			$now = Carbon::now();
			$now->format('Y-m-d');  
			// chek for modality year
			if($rq->modality == 'bub'){

				if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2015_BUB_RFR_FINDINGS;
                    $cmfs_bub->rfr_id = $rq->rfr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
					
				}else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2016_BUB_RFR_FINDINGS;
                    $cmfs_bub->rfr_id = $rq->rfr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
					
				}else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2017_BUB_RFR_FINDINGS;
                    $cmfs_bub->rfr_id = $rq->rfr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
					
				}else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2018_BUB_RFR_FINDINGS;
                    $cmfs_bub->rfr_id = $rq->rfr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
					
				}else if($rq->year == '2020'){

                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2020_BUB_RFR_FINDINGS;
                    $cmfs_bub->rfr_id = $rq->rfr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
					
				}else;

			}else if($rq->modality == 'ncddp'){

				if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                }
                    $cmfs_ncddp->save();
				}else if($rq->year == '2016'){
					foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
				}else if($rq->year == '2017'){
					foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
				}else if($rq->year == '2018'){
					foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
				}else if($rq->year == '2019'){
					foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
				}else if($rq->year == '2020'){
					foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_RFR_FINDINGS;
                    $cmfs_ncddp->rfr_id = $rq->rfr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
				}else;
			}

            DB::commit();
        	return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function set_findings_complied(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
			$now = Carbon::now();
			$now->format('Y-m-d');  
			// chek for modality year
			if($rq->modality == 'bub'){

				if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2015_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
					
				}else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2016_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
					
				}else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2017_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
					
				}else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2018_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
					
				}else if($rq->year == '2020'){
					CMFS_kalahi_2020_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
				}else;

			}else if($rq->modality == 'ncddp'){

				if($rq->year == '2015'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2015_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
					}
				}else if($rq->year == '2016'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2016_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
					}
				}else if($rq->year == '2017'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2017_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
					}
				}else if($rq->year == '2018'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2018_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
					}
				}else if($rq->year == '2019'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2019_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d')));
					}
				}else if($rq->year == '2020'){
					foreach ($rq->obj as $key) {
					CMFS_kalahi_2020_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d')));
					}
				}else;
			}

            DB::commit();
        	return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function update_findings_complied(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
			$now = Carbon::now();
			$now->format('Y-m-d');  
			// chek for modality year
			if($rq->modality == 'bub'){

				if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2015_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
					
				}else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2016_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
					
				}else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2017_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
					
				}else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
					CMFS_kalahi_2018_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
					
				}else if($rq->year == '2020'){
					CMFS_kalahi_2020_BUB_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else;

			}else if($rq->modality == 'ncddp'){

				if($rq->year == '2015'){
					CMFS_kalahi_2015_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else if($rq->year == '2016'){
					CMFS_kalahi_2016_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else if($rq->year == '2017'){
					CMFS_kalahi_2017_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else if($rq->year == '2018'){
					CMFS_kalahi_2018_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else if($rq->year == '2019'){
					CMFS_kalahi_2019_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else if($rq->year == '2020'){
					CMFS_kalahi_2020_NCDDP_RFR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
				}else;
			}

            DB::commit();
        	return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function fetch_spcr(Request $rq){
        ob_start('ob_gzhandler');
    	if($rq->sp_groupings == 1 || $rq->sp_groupings == 2 || $rq->sp_groupings == 4 || $rq->sp_groupings == 5 || $rq->sp_groupings == 6){
	    	$data = Sp::with(['CMFS_kalahi_2015_BUB_SPCR.CMFS_kalahi_2015_BUB_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2016_BUB_SPCR.CMFS_kalahi_2016_BUB_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2017_BUB_SPCR.CMFS_kalahi_2017_BUB_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2018_BUB_SPCR.CMFS_kalahi_2018_BUB_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2020_BUB_SPCR.CMFS_kalahi_2020_BUB_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with('CMFS_kalahi_2016_BUB_SP')
                ->with('CMFS_kalahi_2017_BUB_SP')
                ->with('CMFS_kalahi_2018_BUB_SP')
                ->with('CMFS_kalahi_2020_BUB_SP')
				->where('sp_id', $rq->sp_id)
				->get();

			if($data[0]->CMFS_kalahi_2015_BUB_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2015_BUB_SPCR->CMFS_kalahi_2015_BUB_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2016_BUB_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2016_BUB_SPCR->CMFS_kalahi_2016_BUB_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2017_BUB_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2017_BUB_SPCR->CMFS_kalahi_2017_BUB_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2018_BUB_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2018_BUB_SPCR->CMFS_kalahi_2018_BUB_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2020_BUB_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2020_BUB_SPCR->CMFS_kalahi_2020_BUB_SPCR_FINDINGS->groupBy('department')];
			}else{
				return $data;
			};

    	}else{

	    	$data = Sp::with(['CMFS_kalahi_2015_NCDDP_SPCR.CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2016_NCDDP_SPCR.CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2017_NCDDP_SPCR.CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2018_NCDDP_SPCR.CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->with(['CMFS_kalahi_2019_NCDDP_SPCR.CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
				->
				with(['CMFS_kalahi_2020_NCDDP_SPCR.CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS' => function($eee){
					$eee->get()->groupBy('department');
				}])
                ->with('CMFS_kalahi_2015_NCDDP_SP')
                ->with('CMFS_kalahi_2016_NCDDP_SP')
                ->with('CMFS_kalahi_2017_NCDDP_SP')
                ->with('CMFS_kalahi_2018_NCDDP_SP')
                ->with('CMFS_kalahi_2019_NCDDP_SP')
                ->with('CMFS_kalahi_2020_NCDDP_SP')
				->where('sp_id', $rq->sp_id)
				->get();

			if($data[0]->CMFS_kalahi_2015_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2015_NCDDP_SPCR->CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2016_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2016_NCDDP_SPCR->CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2017_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2017_NCDDP_SPCR->CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2018_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2018_NCDDP_SPCR->CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2019_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2019_NCDDP_SPCR->CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else if($data[0]->CMFS_kalahi_2020_NCDDP_SPCR != null){
				return [$data[0],$data[0]->CMFS_kalahi_2020_NCDDP_SPCR->CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS->groupBy('department')];

			}else{
				return $data;
			};
    	}

        ob_end_flush();
    }


    public function submit_spcr_findings(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            $now = Carbon::now();
            $now->format('Y-m-d');  
            // chek for modality year
            // return $rq;
            if($rq->modality == 'bub'){

                if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2015_BUB_SPCR_FINDINGS;
                    $cmfs_bub->sp_id = $rq->spcr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
                    
                }else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2016_BUB_SPCR_FINDINGS;
                    $cmfs_bub->sp_id = $rq->spcr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
                    
                }else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2017_BUB_SPCR_FINDINGS;
                    $cmfs_bub->sp_id = $rq->spcr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
                    
                }else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2018_BUB_SPCR_FINDINGS;
                    $cmfs_bub->sp_id = $rq->spcr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
                    
                }else if($rq->year == '2020'){

                foreach ($rq->obj as $key) {
                    $cmfs_bub = new CMFS_kalahi_2020_BUB_SPCR_FINDINGS;
                    $cmfs_bub->sp_id = $rq->spcr_id;
                    $cmfs_bub->finding = $key['rfr_eng_findings'];
                    $cmfs_bub->department=2;
                    $cmfs_bub->date = $now->format('Y-m-d');
                    $cmfs_bub->date_complied = $key['date_complied'];
                    $cmfs_bub->complied = 0;
                    $cmfs_bub->days = $key['days'];
                    $cmfs_bub->save();
                }
                    
                }else;

            }else if($rq->modality == 'ncddp'){

                if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                }
                    $cmfs_ncddp->save();
                }else if($rq->year == '2016'){
                    foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
                }else if($rq->year == '2017'){
                    foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
                }else if($rq->year == '2018'){
                    foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
                }else if($rq->year == '2019'){
                    foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
                }else if($rq->year == '2020'){
                    foreach ($rq->obj as $key) {
                    $cmfs_ncddp = new CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS;
                    $cmfs_ncddp->spcr_id = $rq->spcr_id;
                    $cmfs_ncddp->finding = $key['rfr_eng_findings'];
                    $cmfs_ncddp->department=2;
                    $cmfs_ncddp->date = $now->format('Y-m-d');
                    $cmfs_ncddp->date_complied = $key['date_complied'];
                    $cmfs_ncddp->complied = 0;
                    $cmfs_ncddp->save();
                    }
                }else;
            }

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function set_findings_complied_spcr(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            $now = Carbon::now();
            $now->format('Y-m-d');  
            // chek for modality year
            if($rq->modality == 'bub'){

                if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2015_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
                    
                }else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2016_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
                    
                }else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2017_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
                    
                }else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2018_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }
                    
                }else if($rq->year == '2020'){
                    CMFS_kalahi_2020_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                }else;

            }else if($rq->modality == 'ncddp'){

                if($rq->year == '2015'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                    }
                }else if($rq->year == '2016'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                    }
                }else if($rq->year == '2017'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                    }
                }else if($rq->year == '2018'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d'), 'date_complied' => $rq->set_findings_date_complied));
                    }
                }else if($rq->year == '2019'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d')));
                    }
                }else if($rq->year == '2020'){
                    foreach ($rq->obj as $key) {
                    CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('complied' => 1, 'date' => $now->format('Y-m-d')));
                    }
                }else;
            }

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }

    public function update_findings_complied_spcr(Request $rq){
        ob_start('ob_gzhandler');
        DB::beginTransaction();
        try {
            $now = Carbon::now();
            $now->format('Y-m-d');  
            // chek for modality year
            if($rq->modality == 'bub'){

                if($rq->year == '2015'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2015_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
                    
                }else if($rq->year == '2016'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2016_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
                    
                }else if($rq->year == '2017'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2017_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
                    
                }else if($rq->year == '2018'){
                foreach ($rq->obj as $key) {
                    CMFS_kalahi_2018_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }
                    
                }else if($rq->year == '2020'){
                    CMFS_kalahi_2020_BUB_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else;

            }else if($rq->modality == 'ncddp'){

                if($rq->year == '2015'){
                    CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else if($rq->year == '2016'){
                    CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else if($rq->year == '2017'){
                    CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else if($rq->year == '2018'){
                    CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else if($rq->year == '2019'){
                    CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else if($rq->year == '2020'){
                    CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS::where('id', $rq->findings_id)->where('department', 2)->update(array('finding' => $rq->edited_rfr_eng_findings));
                }else;
            }

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        ob_end_flush();
    }


}
