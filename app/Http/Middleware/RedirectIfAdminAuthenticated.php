<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('admin_id')) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
