<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CheckAdminCookie
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('admin_id') && Cookie::has('remember_admin')) {
            $token = Cookie::get('remember_admin');
            $user  = DB::table('admin')->where('COOKIEDANGNHAP', $token)->first();

            if ($user) {
                $request->session()->put('admin_id', $user->ID);
            }
        }
        return $next($request);
    }
}
