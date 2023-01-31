<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    //Show signup form
    public function create(){
        return view('users.signup');
    }

    //Store Formfields to database
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required','min:3'],
            'email' => ['required','email', Rule::unique('users', 'email')],
            //the code below checks if the password match.
            'password' => ['required','confirmed', 'min:6'] 
        ]);
        //Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user = User::create($formFields);
        //Login
        auth()->login($user);
        return redirect('/')->with('message', 'Sign up successful');
    }

    //Logout user
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');
    }

    //Show signup form
    public function login(){
        return view('users.signin');
    }

    //Authenticate User
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required','email'],
            'password' => 'required'
        ]);
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in');
        }
        return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');
        
    }
}
