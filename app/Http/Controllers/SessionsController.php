<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationExeption;


class SessionsController extends Controller
{
    public function create(){
        return view('sessions.create');
    }

    public function store(){
        //validate the request
        $attributes=request()->validate([
            'email'=>'requiered|exists:unique:users,email',
            'password'=>'requiered'
        ]);

        //attempt authenticate and to log in the user
        //based on the provided credentials
        if(auth()->attempt($attributes)){
            session()-regenerate();
            
            //redirect wirh a success flash message
            return redirect('/')->with('success', 'Welcome Back!');
        }

        //auth failed
        throw ValidationExeption::withMessages([
            'email' => 'Your provided credentials could not be verified.'
        ]);
    }

    public function destroy(){
        auth()->logout();

        return redirect("/")->with('success', 'Goodbye!');
    }
}
