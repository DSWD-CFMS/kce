<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
}
