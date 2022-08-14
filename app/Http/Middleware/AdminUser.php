<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth_user = Auth::id();
        $is_admin = DB::table('users')->where('id', $auth_user)->where('is_admin', true)->first();
        if (!$is_admin){
            // return whatever you want here, I'd redirect to homepage for example or some 401 page
            return response()->json(['error' => 'true', 'message' => 'unauthenticated'],401);
        }

        return $next($request);
    }



}
