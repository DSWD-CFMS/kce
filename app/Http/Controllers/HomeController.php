<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Users;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['loginsso']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin(){
        return view('user_admin.home');
    }

    public function rpmo(){
        return view('user_rpmo.home');
    }

    public function dac(){
        return view('user_dac.home');
    }

    public function admin_rcis(){
        return view('user_admin_rcis.home');
    }

    public function loginsso($username,$oauth){
       
        $user = User::where(['username'=>$username])->first();
        if($user){
            Auth::login($user,true);
            if(Auth::check()){
                $user->oauth = $oauth;
                $user->save();
            }
        }else{

            $query = DB::connection('mysql3')->select("SELECT * FROM user WHERE username='".$username."' LIMIT 1");
            foreach($query as $row){
                $addnew = new User;
                $addnew->assigned_grouping = 1;
                $addnew->fname = $row->lastname;
                $addnew->mname = '';
                $addnew->lname = $row->firstname;
                // $addnew->emp_id_no = $rq->emp_id_no;
                // $addnew->birthdate = $rq->bdate;
                // $addnew->email = $rq->email;
                // $addnew->contact = $rq->contact;
                $addnew->username = $username;
                $addnew->password = Hash::make("password");
                $addnew->role = "RPMO";
                $addnew->save();
                Auth::login($addnew,true);
                if(Auth::check()){
                    $addnew->oauth = $oauth;
                    $addnew->save();
                }
            }
        }
        return view('home');
    }
}
