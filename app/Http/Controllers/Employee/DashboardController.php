<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Training;
use App\Models\Rank;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Versuche den authentifizierten Benutzer zu finden
        $employee = auth()->guard('employee')->user();
        
        // Fallback auf Session (für bestehende Authentifizierung)
        if (!$employee && session('employee_authenticated') && session('employee')) {
            $employee = \App\Models\Employee::with('rank')->find(session('employee')['id']);
        }
        
        // Sicherstellen, dass der Employee mit Rank geladen ist
        if ($employee && !$employee->relationLoaded('rank')) {
            $employee->load('rank');
        }
        
        if (!$employee) {
            return redirect()->route('home')->with('error', 'Bitte melden Sie sich als Mitarbeiter an.');
        }

        // Alle Mitarbeiter mit Rang und Ausbildungen laden (für Employee Tab)
        $employees = Employee::with(['rank', 'trainings'])
            ->orderBy('rank_id', 'desc')
            ->orderBy('first_name', 'asc')
            ->get()
            ->map(function ($emp) use ($employee) {
                return [
                    'id' => $emp->id,
                    'steam_id' => $emp->steam_id,
                    'first_name' => $emp->first_name,
                    'last_name' => $emp->last_name,
                    'phone_number' => $emp->phone_number,
                    'rank' => $emp->rank,
                    'is_dispatcher' => $emp->is_dispatcher,
                    'duty_status' => $emp->duty_status,
                    'duty_started_at' => $emp->duty_started_at,
                    'current_location' => $emp->current_location,
                    // Interne Notizen nur für COO und CEO anzeigen
                    'internal_notes' => $employee->canEditEmployees() ? $emp->internal_notes : null,
                    'trainings' => $emp->trainings->map(function ($training) {
                        return [
                            'id' => $training->id,
                            'name' => $training->name,
                            'code' => $training->code,
                            'completed_at' => $training->pivot->completed_at,
                            'expires_at' => $training->pivot->expires_at,
                            'trainer_id' => $training->pivot->trainer_id,
                            'notes' => $training->pivot->notes,
                            'is_expired' => $training->pivot->expires_at && $training->pivot->expires_at < now(),
                        ];
                    }),
                ];
            });

        // Alle verfügbaren Trainings laden
        $trainings = Training::orderBy('name')->get();

        // Alle Ränge laden
        $ranks = Rank::orderBy('level', 'desc')->get();

        // Berechtigungen basierend auf dem aktuellen Mitarbeiter
        $permissions = [
            'canManageTrainings' => $employee->canManageTrainings(),
            'canEditEmployees' => $employee->canEditEmployees(),
        ];

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
            'employees' => $employees,
            'trainings' => $trainings,
            'ranks' => $ranks,
            'permissions' => $permissions,
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
        // Logout from employee guard
        auth()->guard('employee')->logout();
        
        // Clear session data (for backward compatibility)
        session()->forget(['employee', 'employee_authenticated']);
        
        return redirect()->route('home');
    }

    public function updateEmployee(Request $request, Employee $employee)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        // Prüfen ob der aktuelle Benutzer Mitarbeiter bearbeiten darf
        if (!$currentEmployee->canEditEmployees()) {
            return redirect()->back()->with('error', 'Sie haben keine Berechtigung, Mitarbeiter zu bearbeiten.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'rank_id' => 'required|exists:ranks,id',
            'is_dispatcher' => 'boolean',
            'internal_notes' => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect()->back()->with('success', 'Mitarbeiter erfolgreich aktualisiert.');
    }

    public function addTraining(Request $request, Employee $employee)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        // Prüfen ob der aktuelle Benutzer Trainings verwalten darf
        if (!$currentEmployee->canManageTrainings()) {
            return redirect()->back()->with('error', 'Sie haben keine Berechtigung, Ausbildungen zu verwalten.');
        }

        $validated = $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'completed_at' => 'required|date',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Prüfen ob der Mitarbeiter die Ausbildung bereits hat
        if ($employee->trainings()->where('training_id', $validated['training_id'])->exists()) {
            return redirect()->back()->with('error', 'Der Mitarbeiter hat diese Ausbildung bereits.');
        }

        $employee->trainings()->attach($validated['training_id'], [
            'completed_at' => $validated['completed_at'],
            'expires_at' => $validated['expires_at'],
            'trainer_id' => $currentEmployee->id,
            'notes' => $validated['notes'],
        ]);

        return redirect()->back()->with('success', 'Ausbildung erfolgreich hinzugefügt.');
    }

    public function removeTraining(Request $request, Employee $employee, Training $training)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        // Prüfen ob der aktuelle Benutzer Trainings verwalten darf
        if (!$currentEmployee->canManageTrainings()) {
            return redirect()->back()->with('error', 'Sie haben keine Berechtigung, Ausbildungen zu verwalten.');
        }

        $employee->trainings()->detach($training->id);

        return redirect()->back()->with('success', 'Ausbildung erfolgreich entfernt.');
    }
}
