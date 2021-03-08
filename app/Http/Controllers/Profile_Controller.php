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
use App\CMFS_NCDDP_2019;
use App\CMFS_brgy;
use App\CMFS_muni;
use App\CMFS_provinces;


class Profile_Controller extends Controller
{
    public function show_profile(Request $rq){
    	ob_start('ob_gzhandler');
    		$my_account = Users::with('Assigned_grouping.Sp')->with('Assigned_grouping.Sp_groupings')->with('Assigned_sp.Sp_groupings')->with('Files')->where('id',Auth::User()->id)->get();
			$DAC = Users::where('role','DAC')->get()->count();
			$RPMO = Users::where('role','RPMO')->get()->count();
            $PhotoObj = Files::where('origin',Auth::User()->id)->where('category','Profile')->get();
            $modality = Assigned_grouping::with('Sp_groupings')->where('assigned_to',Auth::User()->id)->get()->unique('sp_grouping_id');
            $data_arr = [];
            foreach ($modality as $key) {
                array_push($data_arr,$key->sp_grouping_id);
            }
			return [$my_account,$DAC,$RPMO,$PhotoObj,$data_arr, $modality];
        ob_end_flush();
    }

    public function update_profile_photo(Request $rq){
        DB::beginTransaction();
        try {
        	// Get Info
        	$info = Users::select('id','username','Fname','Mname','Lname','role')->where('id',Auth::User()->id)->get();

        	$Account;
        	if($info[0]->role == "DAC"){
	        	$Account = "DAC";
        	}else if($info[0]->role == "RPMO"){
	        	$Account = "RPMO";
        	}else if($info[0]->role == "ADMIN_RCIS"){
	        	$Account = "RCIS";
        	}else if($info[0]->role == "ADMIN"){
	        	$Account = "ADMIN";
        	}else if($info[0]->role == "PROCUREMENT"){
                $Account = "PROCUREMENT";
            }else if($info[0]->role == "MAINSTREAM"){
                $Account = "MAINSTREAM";
            }else if($info[0]->role == "AIDE"){
                $Account = "AIDE";
            }else;

            $PhotoObj = Files::where('origin',Auth::User()->id)->where('category','Profile')->get();
			$user_folder = Auth::User()->username;

            if(sizeof($PhotoObj) == 1){
            	// delete ang photo
	            Storage::disk('public')->deleteDirectory("profile/$Account/".$user_folder."/Profile/".$PhotoObj[0]->name);
	            // Delete photo in sql;
	            Files::where('origin',Auth::User()->id)->where('category','Profile')->delete();

	            foreach ($rq->file as $key) {
		            $name = $key->getClientOriginalName();

		            $addnew = new Files;
		            $addnew->filename = $name;
		            $addnew->origin = Auth::User()->id;
		            $addnew->category = "Profile";
		            Storage::disk("public")->put("profile/$Account/$user_folder/Profile/$name",file_get_contents($key));
		            $addnew->path = "profile/$Account/$user_folder/Profile/$name";
		            $addnew->save();
	        	}
            }else if(sizeof($PhotoObj) == 0){
	            foreach ($rq->file as $key) {
		            $name = $key->getClientOriginalName();

		            $addnew = new Files;
		            $addnew->filename = $name;
		            $addnew->origin = Auth::User()->id;
		            $addnew->category = "Profile";
		            Storage::disk("public")->put("profile/$Account/$user_folder/Profile/$name",file_get_contents($key));
		            $addnew->path = "profile/$Account/$user_folder/Profile/$name";
		            $addnew->save();
	        	}
            }else;

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function update_profile_info(Request $rq){
        DB::beginTransaction();
        try {
        	// Select User where Auth ID
			Users::where('id',Auth::User()->id)->update([
				'Fname' => $rq->Fname,
				'Mname' => $rq->Mname,
				'Lname' => $rq->Lname,
				'email' => $rq->email,
				'emp_id_no' => $rq->emp_id_no,
				'contact' => $rq->contact,
			]);

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function get_profile_photo(Request $rq){
    	ob_start('ob_gzhandler');
            $path = Files::where('origin',$rq->photos_id)->where('category','Profile')->get();
			// $path = Files::where('origin',Auth::User()->id)->where('category','Profile')->get();

	        $file = Storage::disk("public")->get($path[0]->path);
	        return response($file, 200)->header('Content-Type', 'image/jpeg');
        ob_end_flush();
    }

}
