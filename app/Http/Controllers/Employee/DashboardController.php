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

        // Mock data - später durch echte Daten aus der Datenbank ersetzen
        $stats = [
            'todayOrders' => 12,
            'yourOrders' => 33,
            'todayEarnings' => 1850,
        ];
        
        $recentOrders = [
            [
                'id' => 1,
                'customerName' => 'Max Mustermann',
                'location' => 'Downtown LS',
                'amount' => 150,
                'time' => '14:30',
                'status' => 'completed',
            ],
            [
                'id' => 2,
                'customerName' => 'Anna Schmidt',
                'location' => 'Sandy Shores',
                'amount' => 220,
                'time' => '13:15',
                'status' => 'active',
            ],
            [
                'id' => 3,
                'customerName' => 'Tom Weber',
                'location' => 'Paleto Bay',
                'amount' => 180,
                'time' => '12:45',
                'status' => 'pending',
            ],
        ];

        return Inertia::render('Employee/Dashboard', [
            'employee' => $employee,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'assignments' => [],
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
