<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Business
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::user());
        // return $next($request);
        if (Auth::check()){
            if (Auth::user()->role_id != 2) {
                if($request->ajax()){
                    return response()->json(['success' => false, 'message' => 'Un-Authenticated Access', 'data' => array() ]);
                }else{
                    return redirect()->route('business.login');
                }
            }else{
                return $next($request);
            }
        }else{
            if($request->ajax()){
                return response()->json(['success' => false, 'message' => 'Session Expired', 'data' => array() ]);
            }else{
                return redirect()->route('business.login');
            }
        }
    }
}
