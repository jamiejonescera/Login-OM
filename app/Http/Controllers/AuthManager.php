<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthManager extends Controller
{
    function login(){
        if(Auth::check()){
            return redirect(route(name:'home'));
        }
        return view('login');
    }

    function registration(){
        if(Auth::check()){
            return redirect(route(name:'home'));
        }
        return view('registration');

    }

    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only(['email', 'password']);
        if(Auth::attempt($credentials)){
            return redirect()->intended(route(name:'home'));
            }
        return redirect(route(name:'login'))->with("error", "Login Details are not valid");
    }
    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'            
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if(!$user){
            return redirect(route(name:'registration'))->with("error", "Regsitration failed, please try again");
        }
        return redirect(route(name:'login'))->with("success", "Registration successful, you  may now log in");
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route(name:'login'));
    }
}
