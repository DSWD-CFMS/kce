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
use App\Spcr_tracking;


class SPCR_Controller extends Controller
{

	public function get_spcr_tracks(Request $rq) {
		$to = new Spcr_tracking;
        $to->setConnection('mysql5');
        // ->where('status','approved')
        $multi = $to->get();

        return $multi;
    }
}
