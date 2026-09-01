<?php

namespace App\Http\Controllers\Demo;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    
    
    public function Index(){
        return view('about');
    } // end mehtod 


    public function ContactMethod(){
        return view('contact');
    }

    public function login(){
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        return view('auth.login');
    }

    public function admin_login(Request $request)
    {
        // dd($request->all());
        $field = 'username';

        $request->merge([$field => $request->input('username')]);

        if (Auth::attempt($request->only($field, 'password'))) {
            $notification = array(
                'message' => 'Successfully Login', 
                'alert-type' => 'success'
            );
            return redirect('/admin')->with($notification);
        }
        $notification = array(
            'message' => 'These credentials do not match our records', 
            'alert-type' => 'success'
        );
        return redirect('/admin/login')->with($notification);
    }

}
