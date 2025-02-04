<?php

namespace App\Http\Controllers;

use Core\Session;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
