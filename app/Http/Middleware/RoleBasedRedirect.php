<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::check()) {
            return redirect('/login');
        };
        if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Project Manager')){
        return response(app()->make('App\Http\Controllers\HomeController')->index());
       } else {       return response(app()->make('App\Http\Controllers\ForemanController')->index());   };
    }
    
}
