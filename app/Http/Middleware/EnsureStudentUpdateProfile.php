<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStudentUpdateProfile
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
            if(auth()->user()->registration_no == null && !$request->routeIs('student.profile.edit') && !$request->routeIs('student.logout') && !$request->routeIs('student.profile.update')){
                $name = auth()->user()->full_name;
                return redirect('student/edit/profile')
                        ->with('error',"$name , please update your profile to continue with your session");
            }
        }
        return $next($request);
    }
}
