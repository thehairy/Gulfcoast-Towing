<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DispatchController extends Controller
{
    public function index()
    {
        $employee = session('employee');
        
        $vehicles = Vehicle::with(['currentAssignment.employee.rank'])
                          ->orderBy('name')
                          ->get()
                          ->map(function ($vehicle) {
                              return [
                                  'id' => $vehicle->id,
                                  'name' => $vehicle->name,
                                  'type' => $vehicle->type,
                                  'license_plate' => $vehicle->license_plate,
                                  'status' => $vehicle->status,
                                  'description' => $vehicle->description,
                                  'requires_special_license' => $vehicle->requires_special_license,
                                  'capabilities' => $vehicle->capabilities,
                                  'current_driver' => $vehicle->currentAssignment ? [
                                      'id' => $vehicle->currentAssignment->employee->id,
                                      'assignment_id' => $vehicle->currentAssignment->id,
                                      'name' => $vehicle->currentAssignment->employee->first_name . ' ' . $vehicle->currentAssignment->employee->last_name,
                                      'rank' => $vehicle->currentAssignment->employee->rank->name,
                                      'duty_status' => $vehicle->currentAssignment->employee->duty_status,
                                      'assigned_at' => $vehicle->currentAssignment->assigned_at,
                                  ] : null,
                              ];
                          });

        $employees = Employee::with('rank')
                           #->where('duty_status', '!=', 'off_duty')
                           ->orderBy('first_name')
                           ->get()
                           ->map(function ($emp) {
                               return [
                                   'id' => $emp->id,
                                   'name' => $emp->first_name . ' ' . $emp->last_name,
                                   'rank' => $emp->rank->name,
                                   'duty_status' => $emp->duty_status,
                                   'is_dispatcher' => $emp->is_dispatcher,
                                   'current_location' => $emp->current_location,
                                   'current_vehicle' => $emp->getCurrentVehicle() ? [
                                       'id' => $emp->getCurrentVehicle()->id,
                                       'name' => $emp->getCurrentVehicle()->name,
                                       'license_plate' => $emp->getCurrentVehicle()->license_plate,
                                   ] : null,
                               ];
                           });

        $dispatchers = Employee::where('is_dispatcher', true)
                             ->where('duty_status', '!=', 'off_duty')
                             ->with('rank')
                             ->get()
                             ->map(function ($emp) {
                                 return [
                                     'id' => $emp->id,
                                     'name' => $emp->first_name . ' ' . $emp->last_name,
                                     'rank' => $emp->rank->name,
                                 ];
                             });

        return Inertia::render('Employee/Dispatch', [
            'employee' => $employee,
            'vehicles' => $vehicles,
            'employees' => $employees,
            'dispatchers' => $dispatchers,
        ]);
    }

    public function assignVehicle(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'employee_id' => 'required|exists:employees,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $employee = session('employee');
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        
        // Prüfen ob das Fahrzeug verfügbar ist
        if (!$vehicle->isAvailable()) {
            return back()->withErrors(['message' => 'Fahrzeug ist nicht verfügbar.']);
        }

        // Aktuelle Zuweisung des Mitarbeiters beenden, falls vorhanden
        VehicleAssignment::where('employee_id', $request->employee_id)
                        ->where('status', 'active')
                        ->update([
                            'status' => 'completed',
                            'returned_at' => now()
                        ]);

        // Neue Zuweisung erstellen
        VehicleAssignment::create([
            'vehicle_id' => $request->vehicle_id,
            'employee_id' => $request->employee_id,
            'assigned_by' => $employee['id'],
            'assigned_at' => now(),
            'notes' => $request->notes,
        ]);

        // Fahrzeugstatus auf "im Dienst" setzen
        $vehicle->update(['status' => 'in_service']);

        return back()->with('success', 'Fahrzeug erfolgreich zugewiesen.');
    }

    public function returnVehicle(Request $request)
    {

        Log::info('Vehicle return request', [
            'assignment_id' => $request->assignment_id,
            'employee_id' => session('employee')['id'],
        ]);
        $request->validate([
            'assignment_id' => 'required|exists:vehicle_assignments,id',
        ]);

        $assignment = VehicleAssignment::with('vehicle')->findOrFail($request->assignment_id);
        $vehicle = $assignment->vehicle;
        
        $assignment->returnVehicle();
        
        // Prüfen ob es ein GCT-Fahrzeug ist (automatisch erstellt)
        if ($vehicle->description === 'GCT Fahrzeug - automatisch erstellt') {
            // GCT-Fahrzeuge werden komplett gelöscht
            $vehicle->delete();
            return back()->with('success', 'GCT-Fahrzeug wurde zurückgegeben und entfernt.');
        } else {
            // Normale Fahrzeuge werden nur auf verfügbar gesetzt
            $vehicle->update(['status' => 'available']);
            return back()->with('success', 'Fahrzeug erfolgreich zurückgegeben.');
        }
    }

    public function addVehicle(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|in:pannenservice,abschlepper_pkw,abschlepper_lkw,kranwagen,helikopter',
            'employee_id' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20',
            'type' => 'required|string|max:100',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        
        // Prüfen ob Mitarbeiter bereits ein Fahrzeug hat
        if ($employee->currentVehicleAssignment) {
            return back()->withErrors(['employee_id' => 'Mitarbeiter hat bereits ein Fahrzeug zugewiesen.']);
        }

        // Prüfen ob Mitarbeiter im Dienst ist
        if ($employee->duty_status === 'off_duty') {
            //return back()->withErrors(['employee_id' => 'Mitarbeiter muss im Dienst sein.']);
        }

        // Fahrzeug erstellen
        $vehicle = Vehicle::create([
            'name' => $request->name,
            'type' => $request->type,
            'license_plate' => $request->license_plate,
            'status' => 'in_service',
            'description' => 'GCT Fahrzeug - automatisch erstellt',
            'requires_special_license' => false,
            'capabilities' => [$request->vehicle_type],
        ]);

        // Fahrzeug sofort zuweisen
        VehicleAssignment::create([
            'vehicle_id' => $vehicle->id,
            'employee_id' => $employee->id,
            'assigned_by' => session('employee')['id'], // Wer hat zugewiesen (Leitstelle)
            'assigned_at' => now(),
            'notes' => 'Fahrzeug automatisch bei Erstellung zugewiesen',
        ]);

        return back()->with('success', "Fahrzeug '{$vehicle->name}' wurde erstellt und {$employee->first_name} {$employee->last_name} zugewiesen.");
    }

    public function updateDutyStatus(Request $request)
    {
        $request->validate([
            'duty_status' => 'required|in:off_duty,available,in_service,busy,break,out_of_service',
        ]);

        $employee = Employee::findOrFail(session('employee')['id']);
        
        $employee->update([
            'duty_status' => $request->duty_status,
            'duty_started_at' => $request->duty_status !== 'off_duty' && $employee->duty_status === 'off_duty' 
                                ? now() 
                                : $employee->duty_started_at
        ]);

        // Fahrzeug zurückgeben wenn Dienst beendet wird
        if ($request->duty_status === 'off_duty') {
            $currentAssignment = $employee->currentVehicleAssignment;
            if ($currentAssignment) {
                $vehicle = $currentAssignment->vehicle;
                $currentAssignment->returnVehicle();
                
                // Prüfen ob es ein GCT-Fahrzeug ist
                if ($vehicle->description === 'GCT Fahrzeug - automatisch erstellt') {
                    $vehicle->delete();
                } else {
                    $vehicle->update(['status' => 'available']);
                }
            }
        }

        // Session aktualisieren
        session(['employee' => $employee->fresh()->load('rank')->toArray()]);

        return back()->with('success', 'Dienststatus aktualisiert.');
    }

    public function toggleDispatcher(Request $request)
    {
        $employee = Employee::findOrFail(session('employee')['id']);
        
        $employee->update([
            'is_dispatcher' => !$employee->is_dispatcher
        ]);

        // Session aktualisieren
        session(['employee' => $employee->fresh()->load('rank')->toArray()]);

        return back()->with('success', $employee->is_dispatcher ? 'Sie sind jetzt Leitstelle.' : 'Leitstelle-Status deaktiviert.');
    }
}
