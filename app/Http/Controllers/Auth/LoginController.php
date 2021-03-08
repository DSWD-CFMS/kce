<?php

namespace App\Http\Controllers\Auth;

include("../vendor/autoload.php");

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

/* for Socket */
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
/* for Socket */

use App\Users;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
 
    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;
 
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
 
        $this->username = $this->findUsername();
    }


    // public function Broadcast_Event($key,$data){
    //     // $version = new Version2X("http://172.26.158.126:3011");  
    //     $version = new Version2X("http://localhost:3011");

    //     $client = new Client($version);

    //     $client->initialize();
    //     $client->emit($key, $data);
    //     $client->close();
    // }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {

        // $user = Users::where('username',$this->username)->first();
        $currently_logged_user = Users::select('id','role')->where('username',$this->username)->get();

        // $data = $currently_logged_user->toArray();
        // $this->Broadcast_Event('Signed_In',$data);
        
        $login = request()->input('login');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);

        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

}
