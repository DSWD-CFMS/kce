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
use Auth;
use Storage;
use DateTime;

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

class SMS_Controller extends Controller
{
	// public function Broadcast_Event($key,$data){
 //        $version = new Version2X("http://localhost:3011");
 //        // $version = new Version2X("http://kce.caraga.dswd.gov.ph:3011");

 //        $client = new Client($version);

 //        $client->initialize();
 //        $client->emit($key, $data);
 //        $client->close();
 //    }

	public function smsapi(Request $rq) {
		ob_start('ob_gzhandler');

		// SP physical updating

		// SP Remarks or Issues & Concerns

		// PMR Updates

		/*  PHP example of an HTTP handler that handles requests from SMS Enabler.
		 *  You can modify and use it for processing of incoming SMS messages and sending automatic SMS replies.
		 *  To use it, put this file on your website and specify its URL in SMS Enabler's SMS-to-Webserver settings, 
		 *  such as http://yourserv.com/sms.php
		 */
		// $_POST['sender'] = '09272677689';
		// $_POST['text'] =  $rq->stringsht;
		// $_POST['sc_datetime'] = date("Y-m-d");

		$senderPhone   = $_POST['sender'];    /* sender's phone number */
		$messageText   = $_POST['text'];      /* text of the message   */

		$sent_dt       = $_POST['sc_datetime'];      /* date and time when the message was sent, in the local time zone of the computer on which SMS Enabler is running */
		/* TODO: IMPLEMENT ANY PROCESSING HERE THAT YOU NEED TO PERFORM UPON RECEIPT OF A MESSAGE */

		// $split = explode(" ", $messageText);
		$split = explode("/", $messageText);
		/* ---- Sending a reply SMS ---- */

		// Setting the recipients of the reply. If not set, the reply is sent
		// back to the sender of the origial SMS message
		if(sizeof($split) != 0 && strtoupper($split[0]) == "SPPU"){

			$split[3] = $split[3] / 100 * 100;
			$split[3] = number_format($split[3], 2);

			$id = Sp_logs::where('sp_id',$split[2])->where('sp_logs_planned_target_date',$split[4])->get();

			$slippage = $split[3] - $id[0]->sp_logs_planned / 100 * 100;
			$slippage = number_format($slippage, 2);
			// Updating
			Sp_logs::where('id',$id[0]->id)->update(['sp_logs_slippage' => $slippage, 'sp_logs_actual' => $split[3]]);

			Sp::where('sp_id',$split[2])->update(['updated_at' => date("Y-m-d h:i")]);
			Assigned_sp::where('sp_id',$split[2])->update(['updated_at' => date("Y-m-d h:i")]);

			$User = Users::where('emp_id_no',$split[1])->get();
			$Sp = Sp::with('Assigned_grouping.Users')->with('Assigned_sp.Users')->with('Sp_logs')->where('sp_id',$split[2])->get();

	        // // BROADCAST EVENT
			if(sizeof($User) != 0 && sizeof($Sp) != 0){

				$contact_sender = $Sp[0]->assigned_sp[0]->users[0]->contact;

				// return $Sp[0]->assigned_grouping[0]->users->contact;
				$contact_rcis = '09153908428';
				// $contact_rcis = '09568625630';
				if($Sp[0]->sp_groupings == 4){
					header("X-SMS-To: ".$Sp[0]->assigned_grouping[0]->users->contact." ".$Sp[0]->assigned_grouping[1]->users->contact." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');
					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "Actual: ". $split[3] .", Slippage: ".$slippage;
				}else{
	
					$contact_rpmo =  $Sp[0]->assigned_grouping[0]->users->contact;
					header("X-SMS-To: ".$contact_rpmo." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');
					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "Actual: ". $split[3] .", Slippage: ".$slippage;
				}

			}else;

		}else if(sizeof($split) != 0 && strtoupper($split[0]) == "SPAICR"){

			// type emp_id sp_id spaicr_type content date
			$id = Sp_logs::where('sp_id',$split[2])->where('sp_logs_planned_target_date',$split[5])->get();
			if(strtoupper($split[3]) == 'ANALYSIS'){
				Sp_logs::where('id',$id[0]->id)->update(['sp_logs_analysis' => $split[4]]);
			
			}else if(strtoupper($split[3]) == 'ISSUES AND CONCERNS'){
				Sp_logs::where('id',$id[0]->id)->update(['sp_logs_issues' => $split[4]]);

			}else if(strtoupper($split[3]) == 'REMARKS'){
				Sp_logs::where('id',$id[0]->id)->update(['sp_logs_remarks' => $split[4]]);
			}else;

			$User = Users::where('emp_id_no',$split[1])->get();
			$Sp = Sp::with('Assigned_grouping.Users')->with('Assigned_sp.Users')->with('Sp_logs')->where('sp_id',$split[2])->get();

	        // // BROADCAST EVENT
			if(sizeof($User) != 0 && sizeof($Sp) != 0){
				$contact_sender = $Sp[0]->assigned_sp->users[0]->contact;
				$contact_rcis = '09153908428';
				// $contact_rcis = '09568625630';
				if($Sp[0]->sp_groupings == 4){

				$contact_rcis = '09153908428';
				$contact_ncddp_1 = '09487864987';
				$contact_ncddp_2 = '09487864987';
				$contact_ncddp_3 = '09487864987';

					header("X-SMS-To: ".$Sp[0]->assigned_grouping[0]->users->contact." ".$Sp[0]->assigned_grouping[1]->users->contact." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');

					if(strtoupper($split[3]) == 'ANALYSIS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "ANALYSIS: ". $split[4];
					}else if(strtoupper($split[3]) == 'ISSUES AND CONCERNS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "ISSUES AND CONCERNS: ". $split[4];
					}else if(strtoupper($split[3]) == 'REMARKS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "REMARKS: ". $split[4];
					}else;

				}else{
	
					$contact_rcis = '09153908428';
					header("X-SMS-To: ".$contact_rpmo." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');

					if(strtoupper($split[3]) == 'ANALYSIS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "ANALYSIS: ". $split[4];
					}else if(strtoupper($split[3]) == 'ISSUES AND CONCERNS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "ISSUES AND CONCERNS: ". $split[4];
					}else if(strtoupper($split[3]) == 'REMARKS'){
    					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". "REMARKS: ". $split[4];
					}else;
				}

			}else;

		}else if(sizeof($split) != 0 && strtoupper($split[0]) == "PMR"){
			// type emp_id sp_id code_pap pmr_data_type date_occured
			// 0 - PMR = $split[0]
			// 1 - EMPLOYEE ID = $split[1]
			// 2 - SP ID = $split[2]
			// 3 - CODE (PAP) = $split[3]
			// 4 - 	apa_pre_proc_con,apa_ads,apa_prebid_con,apa_eligibility_check,apa_open_of_bids,apa_bid_eval,apa_post_qual,apa_notice_of_award,apa_contract_signing,apa_notice_to_proceed,apa_contract_review_date,apa_target_date_of_completion,apa_delivery,apa_acceptance,date_contractors_eval_conducted,io_prebid_con,io_eligibility_check,io_open_of_bids,io_bid_eval,io_post_qual,delivery
			// 5 - DATE OCCURED
			// 6 - REMARKS

			// return Sp_pmr::where('sp_id',$split[2])->where('code', $split[3])->get();
			$User = Users::where('emp_id_no',$split[1])->get();
			$Sp = Sp::with('Assigned_grouping.Users')->with('Assigned_sp.Users')->with('Sp_logs')->where('sp_id',$split[2])->get();
			if(sizeof($User) != 0 && sizeof($Sp) != 0){

				$pmr_id = Sp_pmr::where('sp_id',$split[2])->where('code', $split[3])->get();

				// check for existing records
				$addnew = new Sp_pmr_remarks_logs;
                $addnew->pmr_id = $pmr_id[0]['id'];
                $addnew->updated_field = $split[4];
                $addnew->pmr_remarks = $split[6];
                $addnew->save();
                
                Sp_pmr::where('sp_id',$split[2])->where('code', $split[3])->update(array($split[4] => $split[5]));
				// Sp_pmr_remarks_logs::where('sp_id',$split[2])->where('code', $split[3])->update(array('pmr_id' => $pmr_id[0]['id'], 'updated_filed' => $split[4], 'pmr_remarks' => $split[6]));

				// header("X-SMS-To: ".$contact_rpmo." ".$contact_sender." ".$contact_rcis);
				// header('Content-Type: text/plain; charset=utf-8');

				$contact_rcis = '09153908428';
				$procurement1 = '09773140106';
				$procurement2 = '09381010080';
				$procurement3 = '09089077840';
				$procurement4 = '09993994548';

				// $contact_rpmo =  $Sp[0]->assigned_grouping[0]->users->contact;
				header("X-SMS-To: ".$procurement1." ".$procurement2." ".$procurement3." ".$procurement4." ".$contact_rcis);
				header('Content-Type: text/plain; charset=utf-8');

				return "The PMR with a Sub-project ID of ".$split[2]." has been updated by " .$User[0]->Fname ." ". $User[0]->Lname." ". strtoupper($split[4]) ." occured on ". $split[5];
			}else{
				header("X-SMS-To: ".$senderPhone);
				header('Content-Type: text/plain; charset=utf-8');
				return 'Sorry your format is incorrect, Please contact your IT personnel for assistance: 09272677689/09568625630';
			}


		}else if(sizeof($split) != 0 && strtoupper($split[0]) == "SPSTOG"){
			// 0 - SPSTOG = $split[0]
			// 1 - EMPLOYEE ID = $split[1]
			// 2 - SP ID = $split[2]
			// 3 - DATE STARTED = $split[3] sp_date_started
			$User = Users::where('emp_id_no',$split[1])->get();
			$Sp = Sp::with('Assigned_grouping.Users')->with('Assigned_sp.Users')->with('Sp_logs')->where('sp_id',$split[2])->get();
			// Sp::where('sp_id',$split[2])->update(array('sp_date_started' => $split[3], 'status' => 'On-going'));
			// Assigned_sp::where('sp_id',$split[2])->update(array('status' => 'On-going'));
	        // // BROADCAST EVENT
			if(sizeof($User) != 0 && sizeof($Sp) != 0){

				Sp::where('sp_id',$split[2])->update(array('sp_date_started' => $split[3], 'sp_status' => 'On-going'));
				Assigned_sp::where('sp_id',$split[2])->update(array('status' => 'On-going'));

				$contact_sender = $Sp[0]->assigned_sp[0]->users[0]->contact;

				$contact_rcis = '09153908428';
				// $contact_rcis = '09568625630';
				if($Sp[0]->sp_groupings == 4){
					header("X-SMS-To: ".$Sp[0]->assigned_grouping[0]->users->contact." ".$Sp[0]->assigned_grouping[1]->users->contact." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');
					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated from 'NOT YET STARTED' to 'ON-GOING' by " .$User[0]->Fname ." ". $User[0]->Lname."";
				}else{
					$contact_rpmo =  $Sp[0]->assigned_grouping[0]->users->contact;
					header("X-SMS-To: ".$contact_rpmo." ".$contact_sender." ".$contact_rcis);
					header('Content-Type: text/plain; charset=utf-8');
					return "Update: Sub-project ID ".$Sp[0]->sp_id." has been updated from 'NOT YET STARTED' to 'ON-GOING' by " .$User[0]->Fname ." ". $User[0]->Lname."";
				}

			}else;

		}else{
			header("X-SMS-To: ".$senderPhone);
			header('Content-Type: text/plain; charset=utf-8');
			return 'Sorry your format is incorrect, Please contact your IT personnel for assistance: 09272677689/09568625630';
		};
		
		ob_end_flush();
	}

	public function sms_list(Request $rq){
        $Sms = new Sms;
        $Sms->setConnection('mysql2');
        $multi = $Sms->get();

        return $multi;
	}

}