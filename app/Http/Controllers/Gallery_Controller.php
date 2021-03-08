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
use App\Gallery;
use App\Gallery_Images;

class Gallery_Controller extends Controller
{

	public function fetch_gallery(Request $rq) {

		$data = Gallery::with('Gallery_Images')->get();
		return $data;
    }

    public function fetch_gallery_Image(Request $rq){
        $path = Gallery_Images::select('path')->where('id', $rq->id)->get();

        $file = Storage::disk("public")->get($path[0]->path);
        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }
}
