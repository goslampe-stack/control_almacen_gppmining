<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificarLogin extends Controller
{
    public function showLoginForm()
    {
        
        if (\Auth::guest()) {
            return view('auth.login');
        } else {
           
            return redirect()->route('dashboard');
        }
    }
}
