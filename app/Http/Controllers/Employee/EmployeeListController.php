<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Training;
use App\Models\EmployeeTraining;
use App\Models\Rank;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeListController extends Controller
{
    public function index(Request $request)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        // Alle Mitarbeiter mit Rang und Ausbildungen laden
        $employees = Employee::with(['rank', 'trainings'])
            ->orderBy('rank_id', 'desc')
            ->orderBy('first_name', 'asc')
            ->get()
            ->map(function ($employee) use ($currentEmployee) {
                return [
                    'id' => $employee->id,
                    'steam_id' => $employee->steam_id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'phone_number' => $employee->phone_number,
                    'rank' => $employee->rank,
                    'is_dispatcher' => $employee->is_dispatcher,
                    'duty_status' => $employee->duty_status,
                    'duty_started_at' => $employee->duty_started_at,
                    'current_location' => $employee->current_location,
                    // Interne Notizen nur für COO und CEO anzeigen
                    'internal_notes' => $currentEmployee->canEditEmployees() ? $employee->internal_notes : null,
                    'trainings' => $employee->trainings->map(function ($training) {
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

        // Alle verfügbaren Ausbildungen
        $trainings = Training::all();

        // Alle Ränge (für Editierung)
        $ranks = Rank::all();

        return Inertia::render('Employee/EmployeeList', [
            'employees' => $employees,
            'trainings' => $trainings,
            'ranks' => $ranks,
            'permissions' => [
                'canManageTrainings' => $currentEmployee->canManageTrainings(),
                'canEditEmployees' => $currentEmployee->canEditEmployees(),
            ],
        ]);
    }

    public function updateEmployee(Request $request, Employee $employee)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        if (!$currentEmployee->canEditEmployees()) {
            abort(403, 'Keine Berechtigung zum Bearbeiten von Mitarbeitern');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'rank_id' => 'required|exists:ranks,id',
            'is_dispatcher' => 'boolean',
            'internal_notes' => 'nullable|string',
        ]);

        $employee->update($request->only([
            'first_name',
            'last_name', 
            'phone_number',
            'rank_id',
            'is_dispatcher',
            'internal_notes'
        ]));

        return back()->with('success', 'Mitarbeiter erfolgreich aktualisiert');
    }

    public function addTraining(Request $request, Employee $employee)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        if (!$currentEmployee->canManageTrainings()) {
            abort(403, 'Keine Berechtigung zum Verwalten von Ausbildungen');
        }

        $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'completed_at' => 'required|date',
            'expires_at' => 'nullable|date|after:completed_at',
            'notes' => 'nullable|string',
        ]);

        // Prüfen ob bereits eine Ausbildung dieses Typs existiert
        $existingTraining = EmployeeTraining::where('employee_id', $employee->id)
            ->where('training_id', $request->training_id)
            ->first();

        if ($existingTraining) {
            // Update existing training
            $existingTraining->update([
                'completed_at' => $request->completed_at,
                'expires_at' => $request->expires_at,
                'trainer_id' => $currentEmployee->id,
                'notes' => $request->notes,
            ]);
        } else {
            // Create new training
            EmployeeTraining::create([
                'employee_id' => $employee->id,
                'training_id' => $request->training_id,
                'completed_at' => $request->completed_at,
                'expires_at' => $request->expires_at,
                'trainer_id' => $currentEmployee->id,
                'notes' => $request->notes,
            ]);
        }

        return back()->with('success', 'Ausbildung erfolgreich hinzugefügt/aktualisiert');
    }

    public function removeTraining(Request $request, Employee $employee, Training $training)
    {
        $currentEmployee = auth()->guard('employee')->user();
        
        if (!$currentEmployee->canManageTrainings()) {
            abort(403, 'Keine Berechtigung zum Verwalten von Ausbildungen');
        }

        EmployeeTraining::where('employee_id', $employee->id)
            ->where('training_id', $training->id)
            ->delete();

        return back()->with('success', 'Ausbildung erfolgreich entfernt');
    }
}
