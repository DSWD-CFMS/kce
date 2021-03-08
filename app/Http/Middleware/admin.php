<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class admin
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
            if(auth()->user()->role == 'ADMIN'){
             return $next($request);
            }
            return redirect('home')->with('error','Restricted Access!');
        }
        else{
          return redirect()->guest(route('login'));
        }
        return $next($request);
    }
}
