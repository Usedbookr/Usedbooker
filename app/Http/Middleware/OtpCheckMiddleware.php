<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class OtpCheckMiddleware
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
        // dd("hi");
        if (Auth::check() && Auth::user()->user_type == 'user'  && Auth::user()->otp_verify == 1) {
            return $next($request);
        }
        elseif (!Auth::check()) {
            return redirect()->route('user.login')->with('success', 'Please Login your Account');
        }
        else{
            return redirect()->route('otpverify')->with('success', 'Please Verify your Account');
        }
    }
}
