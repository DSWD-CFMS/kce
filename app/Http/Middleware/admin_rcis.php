<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class admin_rcis
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(auth::user()->role=='ADMIN_RCIS'){
                return $next($request);
            }elseif (auth::user()->role=='RFA') {
                return $next($request);
            }elseif (auth::user()->role=='RPO') {
                # code...
            }elseif (auth::user()->role=='RMES') {
                return $next($request);
            }elseif (auth::user()->role=='RCBS') {
                return $next($request);
            }elseif (auth::user()->role=='RCDS') {
                return $next($request);
            }else
            return redirect('home')->with('error','Restricted Access!');
        }
        else{
          return redirect()->guest(route('login'));
        }
        return $next($request);
    }
}
