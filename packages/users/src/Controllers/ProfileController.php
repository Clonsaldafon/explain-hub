<?php

namespace Users\Controllers;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('users::profile');
    }
}