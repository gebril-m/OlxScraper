<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    public function login_page()
    {
    	return view('auth.login');
    }

    public function login(Request $request)
    {
    	if (auth()->attempt(['email'=>$request->email,'password'=>$request->password])) {
            if (auth()->user()->hasRole('super-admin')) {
    		  return redirect(url('/'));  
            }
            if (auth()->user()->hasRole('user')) {
              return redirect(url('/user-projects'));  
            }
    	
    	}else{
    		session()->flash('error','Login Invalid');
    		return back();
    	}
    }

    public function logout()
    {
    	Auth::logout();
  		return redirect('/login');
    }
}
