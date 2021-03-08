<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
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

class Users_Controller extends Controller
{
    public function fetch_users_list(Request $rq){
        $users = Users::select('Fname','Lname')->where('Fname','<>','CCL')->where('Fname','<>','NCDDP')->where('Fname','<>','IPCDD')->where('Fname','<>','L&E')->where('Fname','<>','MAKILAHOK')->where('Fname','<>','KKB')->orderBy('id', 'desc')->get();
        return $users;
    }


}
