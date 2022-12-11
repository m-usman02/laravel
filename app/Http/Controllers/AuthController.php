<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function proceedRegister(Request $request)
    {
         $request->validate([               
               'name'=>'required|max:255',
               'email'=>'required|email|max:255|unique:users',
               'password'=>'required|max:255', 
               'confirm_password'=>'required|max:255|same:password',          
           ]);
         $user = User::create([
         'name'=>$request->name,
         'email'=>$request->email,
         'password'=>Hash::make($request->password),     
             
         ]);
        Auth::login($user);
        
            
            return redirect()->route('home');        
            
      
       
        return back()->withErrors([
            'email' => 'Something went wrong',
        ])->onlyInput('email');
    }

    public function proceedLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'           
        ]);

      if (Auth::attempt($credentials)) {
         $request->session()->regenerate();
         
         return redirect()->route('home'); 
         
     }

     return back()->withErrors([
         'email' => 'The provided credentials do not match our records.',
     ])->onlyInput('email');
    }

    public function logout(Request $request)
   {
     Auth::logout();
 
     $request->session()->invalidate();
 
     $request->session()->regenerateToken();
 
     return redirect()->route('login'); 
   } 

    
}
