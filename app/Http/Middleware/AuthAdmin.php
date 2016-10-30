<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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
        
        if (Auth::user()->role != User::ROLE_ADMIN) {
            return redirect('/access');
        }
//        if (Auth::user()->role != User::ROLE_MANAGER) {
//            return redirect('/');
//        }
        return $next($request);
    }
}
