<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureResultVerifierUpdateProfile
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
        if (Auth::check()) {
            if(auth()->user()->enquirer->organization_name == null && !$request->routeIs('verify.result.profile.edit') && !$request->routeIs('verify.result.logout') && !$request->routeIs('verify.result.profile.update')){
                $name = auth()->user()->full_name;
                return redirect('enquirers/edit/profile')
                        ->with('error',"$name , please update your profile to continue with your session");
            }
        }
        return $next($request);
    }
}
