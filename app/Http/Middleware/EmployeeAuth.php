<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prüfe zuerst die Session-basierte Authentifizierung (bestehender Code)
        if (session('employee_authenticated') && session('employee')) {
            // Setze den Benutzer für den employee guard
            auth()->guard('employee')->setUser(
                \App\Models\Employee::find(session('employee')['id'])
            );
            return $next($request);
        }

        // Fallback: Prüfe den employee guard
        if (auth()->guard('employee')->check()) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Bitte melden Sie sich als Mitarbeiter an.');
    }
}
