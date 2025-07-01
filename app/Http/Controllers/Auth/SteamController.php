<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SteamController extends Controller
{
    public function redirect(Request $request)
    {
        $type = $request->get('type', 'employee'); // 'customer' or 'employee'
        
        // Simple Steam OpenID authentication
        $steamOpenId = 'https://steamcommunity.com/openid/login';
        $params = [
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => route('steam.callback', ['type' => $type]),
            'openid.realm' => request()->getSchemeAndHttpHost(),
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        $url = $steamOpenId . '?' . http_build_query($params);
        
        return redirect($url);
    }

    public function callback(Request $request)
    {
        $type = $request->get('type', 'employee');
        
        // Validate OpenID response
        if (!$this->validateSteamLogin($request)) {
            return redirect()->route('home')
                ->withErrors(['steam' => 'Steam authentication failed or was cancelled.']);
        }

        // Extract Steam ID from claimed_id
        $steamId = $this->extractSteamId($request->get('openid_claimed_id'));
        
        if (!$steamId) {
            return redirect()->route('home')
                ->withErrors(['steam' => 'Could not retrieve Steam ID.']);
        }

        if ($type === 'employee') {
            return $this->handleEmployeeLogin($steamId);
        } else {
            return $this->handleCustomerLogin($steamId);
        }
    }

    private function validateSteamLogin(Request $request)
    {
        // Basic validation - in production you should implement full OpenID validation
        return $request->has('openid_claimed_id') && 
               str_contains($request->get('openid_claimed_id'), 'steamcommunity.com/openid/id/');
    }

    private function extractSteamId($claimedId)
    {
        if (preg_match('/steamcommunity\.com\/openid\/id\/(\d+)/', $claimedId, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function handleEmployeeLogin($steamId)
    {
        $employee = Employee::where('steam_id', $steamId)->with('rank')->first();
        
        if (!$employee) {
            return redirect()->route('home')->withErrors(['steam' => 'No employee found with this Steam ID.']);
        }

        // Store employee data in session
        session([
            'employee' => $employee,
            'employee_authenticated' => true,
        ]);

        return redirect()->route('employee.dashboard');
    }

    private function handleCustomerLogin($steamId)
    {
        $user = User::where('steam_id', $steamId)->first();
        
        if (!$user) {
            // Get Steam profile info if available
            $steamProfile = $this->getSteamProfile($steamId);
            
            // Create new user if doesn't exist
            $user = User::create([
                'name' => $steamProfile['personaname'] ?? 'Steam User ' . substr($steamId, -4),
                'email' => $steamId . '@steam.local',
                'steam_id' => $steamId,
                'password' => bcrypt(str()->random(32)), // Random password since we use Steam auth
                'email_verified_at' => now(), // Auto-verify Steam users
            ]);
        }

        Auth::login($user, true);
        
        return redirect()->intended('/kunde');
    }

    private function getSteamProfile($steamId)
    {
        $apiKey = config('services.steam.api_key');
        
        if (!$apiKey) {
            return null;
        }

        try {
            $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$apiKey}&steamids={$steamId}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if (isset($data['response']['players'][0])) {
                return $data['response']['players'][0];
            }
        } catch (\Exception $e) {
            // Log error but don't fail authentication
            \Log::error('Steam API error: ' . $e->getMessage());
        }
        
        return null;
    }
}
