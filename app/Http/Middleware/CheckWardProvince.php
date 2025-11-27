<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckWardProvince
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('sign');
        }
        
        $user = Auth::user()->getAttributes();
        // dd($user);


        if ($role) {
            if ((int)$user["role_id"] === (int)$role) {
                return $next($request);
            }
        } else {
            if (in_array((int)$user["role_id"], [1, 2])) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized role'], 403);
    }
}
