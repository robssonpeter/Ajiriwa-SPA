<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Middleware;

class RoleSelect extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowed_routes = [
            'user.role.selected', 'login', 'register', 'root'
        ];
        $route_name = Route::currentRouteName();
        if(in_array($route_name, $allowed_routes)){
            return $next($request);
        }
        if(Auth::check() && Auth::user()->hasRole('admin')){
            return $next($request);
        }

        if(Auth::check() && !Auth::user()->role){
            return Inertia::render('Auth/UserSelect', []);
        }

        return $next($request);
    }

   /* public function redirectTo($request){
        dd('hello there');

    }*/
}
