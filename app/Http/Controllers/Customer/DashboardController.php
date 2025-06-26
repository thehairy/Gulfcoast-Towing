<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function login()
    {
        return Inertia::render('Customer/Login');
    }

    public function index()
    {
        return Inertia::render('Customer/Dashboard');
    }
}
