<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = session('employee');
        
        if (!$employee || !session('employee_authenticated')) {
            return redirect()->route('employee.login');
        }

        return Inertia::render('Employee/Dashboard', [
            'employee' => $employee,
        ]);
    }

    public function login()
    {
        return Inertia::render('Employee/Login');
    }

    public function logout()
    {
        session()->forget(['employee', 'employee_authenticated']);
        return redirect()->route('home');
    }
}
