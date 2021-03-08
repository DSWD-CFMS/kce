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
use Carbon\Carbon;

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
use App\Spcr_tracking_ncddp_2019;
use App\Spcr_tracking_ncddp_findings_2019;
use App\Spcr_tracking_ncddp_logs_2019;
use App\Department;

use App\Spcr_tracking_bub_2019;
use App\Spcr_tracking_bub_findings_2019;
use App\Spcr_tracking_bub_logs_2019;

class MAINSTREAM_Controller extends Controller
{
    public function index(){
        return view('user_mainstream.home');
    }

	public function get_spcr_tracks(Request $rq) {
        return Spcr_tracking_ncddp_2019::with('Spcr_tracking_ncddp_findings_2019.Department')
        ->with('Spcr_tracking_ncddp_logs_2019')
        ->join('kcengineering_v2.sp as db2', 'tbl_spcrcoa_ncddp.sp_id', '=', 'db2.sp_id')
        ->paginate(100);

        // $to = new Spcr_tracking_ncddp_2019;
        // $to->setConnection('mysql5');
        // $multi = $to->with('Spcr_tracking_ncddp_findings_2019')->with('Spcr_tracking_ncddp_logs_2019')->join('Sp as db2','Spcr_tracking_ncddp_2019.sp_id','=','db2.sp_id')->get();
        // return $multi;
    }
}
