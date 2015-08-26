<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
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
        $is_admin = Auth::user()->roles()->where('name', 'admin')->exists();
         
        if(! $is_admin) {

            return response()->json([
                    "error" => "Unauthorized access"
                ], 401);

        }
        return $next($request);
    }
}
