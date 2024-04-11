<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureAccountIsActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if(auth()->user()->is_account_activated  == 0){
                $email = auth()->user()->email;
                $isStudent = auth()->user()->is_student;
                Auth::logout();
                $request->session()->flush();

                if ($isStudent) {
                    return redirect('students/login')->with('error',"Permission Denied!!! The Account ($email) has not being activated, please check your email for activation code.");
                }

                return redirect('enquirers/login')->with('error',"Permission Denied!!! The Account ($email) has not being activated, please check your email for activation code.");
            }
        }
        return $next($request);
    }
}
