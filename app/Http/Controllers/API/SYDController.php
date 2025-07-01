<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Log;

class SYDController
{
    static private $apiUrl = 'https://utils.switchyourdream.de/v1/';
    static private $allPlayersRoute = 'server/player/all';
    static private $onlinePlayersRoute = 'server/player/online';
    static private $playerDataRoute = 'server/player/data';
    static private $playerTicketsRoute = 'server/player/tickets';

    private function getApiKey()
    {
        return env('SYD_API_KEY');
    }

    private function doRequest($endpoint, $method = 'GET', $data = [], $useQueryParams = false)
    {
        $url = self::$apiUrl . $endpoint;
        $headers = [
            'Authorization' => 'Bearer ' . $this->getApiKey(),
        ];
        
        $httpClient = \Illuminate\Support\Facades\Http::withHeaders($headers);
        
        if ($useQueryParams && !empty($data)) {
            // For GET requests with query parameters
            $response = $httpClient->get($url, $data);
        } else if (!empty($data)) {
            // For requests with JSON body data
            $headers['Content-Type'] = 'application/json';
            $response = $httpClient->withHeaders(['Content-Type' => 'application/json'])->send($method, $url, [
                'json' => $data
            ]);
        } else {
            // For requests without data
            $response = $httpClient->send($method, $url);
        }
        
        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('API request failed: ' . $response->body());
        }
    }

    public function getAllPlayers()
    {
        try {
            $data = $this->doRequest(self::$allPlayersRoute);
            return $this->parsePlayersData($data);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getPlayer($steamid)
    {
        try {
            $data = $this->doRequest(self::$playerDataRoute, 'GET', ['steamid' => $steamid], true);
            return $this->parsePlayerData($data);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Parse the raw API response and structure the player data
     */
    private function parsePlayersData($rawData)
    {
        $parsedPlayers = [];
        
        foreach ($rawData as $index => $player) {
            $steamid = $player['steamid'] ?? null;
            $charactersString = $player['characters'] ?? '';
            
            $parsedPlayers[] = [
                'steamid' => $steamid,
                'characters' => $this->parseCharactersString($charactersString),
                'raw_characters' => $charactersString // Keep original for debugging
            ];
        }
        
        return $parsedPlayers;
    }

    /**
     * Parse the characters string into a structured array
     */
    private function parseCharactersString($charactersString)
    {
        if (empty($charactersString)) {
            return [];
        }

        // Don't trim brackets, work with the full string
        // Updated regex to handle backticks in names: [id,`name` or name,[`birthdate`,`birthplace` or similar]]
        preg_match_all('/\[(\d+),(`[^`]*`|[^,\[]*),\[([^\]]*)\]\]/', $charactersString, $matches, PREG_SET_ORDER);
        
        $characters = [];
        foreach ($matches as $match) {
            $characterId = $match[1];
            $characterName = trim($match[2], '`'); // Remove backticks if present
            $characterInfo = $match[3];
            
            $birthdate = null;
            $birthplace = null;
            
            // Parse character info (birthdate and birthplace)
            // Split by comma but handle backticks properly
            if (!empty($characterInfo)) {
                // Use regex to extract quoted or unquoted values
                preg_match_all('/`([^`]+)`|([^,]+)/', $characterInfo, $infoParts);
                
                $values = [];
                for ($i = 0; $i < count($infoParts[0]); $i++) {
                    $value = !empty($infoParts[1][$i]) ? $infoParts[1][$i] : trim($infoParts[2][$i]);
                    if (!empty($value)) {
                        $values[] = $value;
                    }
                }
                
                $birthdate = isset($values[0]) ? $values[0] : null;
                $birthplace = isset($values[1]) ? $values[1] : null;
            }
            
            // Add all characters with IDs, even if they have empty names
            if (!empty($characterId)) {
                $characters[] = [
                    'id' => (int)$characterId,
                    'name' => !empty($characterName) ? $characterName : null,
                    'birthdate' => $birthdate,
                    'birthplace' => $birthplace
                ];
            }
        }
        
        return $characters;
    }

    /**
     * Parse the complete player data from the API response
     */
    private function parsePlayerData($playerData)
    {
        return [
            'characters' => $this->parseCharactersString($playerData['characters'] ?? ''),
            'phone_numbers' => $this->parsePhoneNumbers($playerData['phone_numbers'] ?? ''),
            'licenses' => [
                'bluefor' => [
                    'level' => (int)($playerData['bluefor_level'] ?? 0),
                    'licenses' => $this->parseLicenses($playerData['bluefor_licenses'] ?? '[]')
                ],
                'independent' => [
                    'level' => (int)($playerData['independent_level'] ?? 0),
                    'licenses' => $this->parseLicenses($playerData['independent_licenses'] ?? '[]')
                ],
                'civilian' => $this->parseLicenses($playerData['civilian_licenses'] ?? '[]')
            ],
            'money_bank' => (int)($playerData['money_bank'] ?? 0),
            'online' => (bool)($playerData['online'] ?? false),
            'first_seen' => $playerData['first_seen'] ?? null,
            'last_seen' => $playerData['last_seen'] ?? null,
            'raw_data' => $playerData // Keep original for debugging
        ];
    }

    /**
     * Parse phone numbers string into a structured array
     */
    private function parsePhoneNumbers($phoneNumbersString)
    {
        if (empty($phoneNumbersString) || $phoneNumbersString === '[]') {
            return [];
        }

        // Parse format: [[4266,`0659177288`]]
        preg_match_all('/\[(\d+),`([^`]*)`\]/', $phoneNumbersString, $matches, PREG_SET_ORDER);
        
        $phoneNumbers = [];
        foreach ($matches as $match) {
            $characterId = (int)$match[1];
            $phoneNumber = $match[2];
            
            $phoneNumbers[] = [
                'character_id' => $characterId,
                'phone_number' => $phoneNumber
            ];
        }
        
        return $phoneNumbers;
    }

    /**
     * Parse licenses string into a structured array
     */
    private function parseLicenses($licensesString)
    {
        if (empty($licensesString) || $licensesString === '[]') {
            return [];
        }

        // Parse format: [[`license_name`,0],[`license_name2`,1]]
        preg_match_all('/\[`([^`]+)`,(\d+)\]/', $licensesString, $matches, PREG_SET_ORDER);
        
        $licenses = [];
        foreach ($matches as $match) {
            $licenseName = $match[1];
            $licenseStatus = (int)$match[2];
            
            $licenses[] = [
                'name' => $licenseName,
                'status' => $licenseStatus,
                'active' => $licenseStatus === 1
            ];
        }
        
        return $licenses;
    }
}
