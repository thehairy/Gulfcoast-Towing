<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceRegulationsController extends Controller
{
    public function index()
    {
        $employee = session('employee');
        
        if (!$employee || !session('employee_authenticated')) {
            return redirect()->route('employee.login');
        }

        // Mock data für Service Regulations
        $serviceRegulations = [
            'general_conduct' => [
                'title' => 'Allgemeines Verhalten',
                'rules' => [
                    'Höflicher und respektvoller Umgang mit Kunden und Kollegen',
                    'Pünktliches Erscheinen zum Dienst',
                    'Professionelle Arbeitskleidung tragen',
                    'Keine privaten Angelegenheiten während der Arbeitszeit'
                ]
            ]
        ];

        return Inertia::render('Employee/ServiceRegulations', [
            'employee' => $employee,
            'serviceRegulations' => $serviceRegulations,
        ]);
    }
}
