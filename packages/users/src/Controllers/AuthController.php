<?php

namespace Users\Controllers;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('users::auth.login');
    }

    public function showRegisterForm()
    {
        return view('users::auth.register');
    }
}