<?php

namespace Questions\Controllers;

use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        return view('questions::questions');
    }
}