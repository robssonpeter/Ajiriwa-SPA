<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;

class ClientVerification
{
    /**
     * Handle an incoming request.
     * This middleware allows or prevents a request from being allowed by validaiting the client id. The clients sent
     * should have a valid licence key
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check the request header if it contains a key clk
        if (!$request->header('clk')) {
            return abort(401);
        }
        
        $client_key = $request->header('clk');
        // get the client information
        $client = DB::connection('clients')->table('clients')->where('hashslug', $client_key)->first();
        //if the client does not exist abort
        if (!$client) {
            return abort(401);
        }
        // check if the client has an active subscription
        $active_licence = DB::connection('clients')->table('licences')
                        ->where('client_id', $client->id)
                        ->where('expiry', '>', date('Y-m-d'))
                        ->first();
        // if the client does not have an active subscription abort
        if (!$active_licence) {
            return abort(401);
        }
        session()->flash('client', $client);
        return $next($request);
    }
}
