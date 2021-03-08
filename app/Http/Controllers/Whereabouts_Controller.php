<?php

namespace App\Http\Controllers;
include("../vendor/autoload.php");

use Illuminate\Http\Request;
use Calendar;
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
use App\Users;
use App\Sms;
use App\KCPIS_TravelOrders;

class Whereabouts_Controller extends Controller
{

	public function get_whereabouts(Request $rq) {
		$now = Carbon::now();
		// return $now->month;
        $users = Users::select('Fname','Lname','emp_id_no','contact')->get();
		$to = new KCPIS_TravelOrders;
        $to->setConnection('mysql3');
        // ->where('status','approved')
        $multi = $to->join('rpmo_staff','rpmo_staff.id_number','=', 'idNumber')->whereMonth('dateFrom', $now->year)->whereYear('dateApproval',$now->year)->whereIn('idNumber', ['00-00005','00-00006','00-00007','00-00008','00-00009','16-03335','16-06238','16-08017','16-08071','16-08203','16-08207','16-08555','16-08958','16-08977','16-09019','16-09345','16-09375','16-09501','16-09603','16-09634','16-09669','16-09676','16-09793','16-10174','16-10186','16-10225','16-10228','16-10564','16-10663','16-10705','16-10786','16-10952','16-10961','16-11015','16-11577','16-11671','16-11678','16-11839','16-77777'])->get();

        return $multi;
    }

}   

