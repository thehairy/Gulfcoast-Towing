<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\SYDController;
use App\Models\Employee;
use App\Models\Rank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportTowingEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employees:import-towing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import employees with towing licenses from SYD API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting import of towing employees...');

        $sydController = new SYDController();
        
        try {
            // Get all players from SYD API
            $allPlayers = $sydController->getAllPlayers();
            
            if (isset($allPlayers['error'])) {
                $this->error('Failed to fetch players: ' . $allPlayers['message']);
                Log::error('Failed to fetch players from SYD API', $allPlayers);
                return 1;
            }

            $importedCount = 0;
            $skippedCount = 0;
            $errorCount = 0;

            // Get the Recovery Associate rank (default rank)
            $defaultRank = Rank::where('name', 'Recovery Associate')->first();
            if (!$defaultRank) {
                $this->error('Recovery Associate rank not found. Please run the rank seeder first.');
                return 1;
            }

            foreach ($allPlayers as $player) {
                try {
                    $steamId = $player['steamid'];
                    
                    if (!$steamId) {
                        $this->warn('Skipping player with no Steam ID');
                        continue;
                    }

                    // Check if employee already exists
                    if (Employee::where('steam_id', $steamId)->exists()) {
                        $skippedCount++;
                        continue;
                    }

                    // Get detailed player data
                    $playerData = $sydController->getPlayer($steamId);
                    
                    if (isset($playerData['error'])) {
                        $this->warn("Failed to fetch detailed data for Steam ID {$steamId}: " . $playerData['message']);
                        $errorCount++;
                        continue;
                    }

                    // Check if player has towing license
                    if (!$this->hasTowingLicense($playerData)) {
                        continue; // Skip players without towing license
                    }

                    // Find the first character with a name to use as employee data
                    $character = $this->findBestCharacter($playerData['characters']);
                    
                    if (!$character) {
                        $this->warn("No valid character found for Steam ID {$steamId}");
                        continue;
                    }

                    // Find phone number for this character
                    $phoneNumber = $this->findPhoneNumber($playerData['phone_numbers'], $character['id']);

                    // Create employee record
                    Employee::create([
                        'steam_id' => $steamId,
                        'first_name' => $this->extractFirstName($character['name']),
                        'last_name' => $this->extractLastName($character['name']),
                        'phone_number' => $phoneNumber ?: 'Unknown',
                        'rank_id' => $defaultRank->id,
                        'is_dispatcher' => false,
                        'duty_status' => 'off_duty',
                    ]);

                    $importedCount++;
                    $this->info("Imported employee: {$character['name']} (Steam ID: {$steamId})");

                } catch (\Exception $e) {
                    $this->error("Error processing player {$steamId}: " . $e->getMessage());
                    Log::error("Error importing employee for Steam ID {$steamId}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $errorCount++;
                }
            }

            $this->info("Import completed!");
            $this->info("Imported: {$importedCount} employees");
            $this->info("Skipped (already exists): {$skippedCount} employees");
            $this->info("Errors: {$errorCount} employees");

            return 0;

        } catch (\Exception $e) {
            $this->error('Import failed: ' . $e->getMessage());
            Log::error('Employee import failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Check if player has a towing license
     */
    private function hasTowingLicense($playerData): bool
    {
        // Check civilian licenses for towing license
        $civilianLicenses = $playerData['licenses']['civilian'] ?? [];
        
        foreach ($civilianLicenses as $license) {
            if (stripos($license['name'], 'towing') !== false && $license['active']) {
                return true;
            }
        }

        // Also check independent licenses (truck drivers might have towing there)
        $independentLicenses = $playerData['licenses']['independent']['licenses'] ?? [];
        
        foreach ($independentLicenses as $license) {
            if (stripos($license['name'], 'towing') !== false && $license['active']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find the best character to use for employee data
     */
    private function findBestCharacter($characters): ?array
    {
        // Prefer characters with names
        foreach ($characters as $character) {
            if (!empty($character['name']) && $character['name'] !== null) {
                return $character;
            }
        }

        // If no named characters, return the first one with an ID
        return $characters[0] ?? null;
    }

    /**
     * Find phone number for a specific character
     */
    private function findPhoneNumber($phoneNumbers, $characterId): ?string
    {
        foreach ($phoneNumbers as $phone) {
            if ($phone['character_id'] === $characterId) {
                return $phone['phone_number'];
            }
        }
        return null;
    }

    /**
     * Extract first name from full name
     */
    private function extractFirstName($fullName): string
    {
        if (empty($fullName)) {
            return 'Unknown';
        }

        $nameParts = explode(' ', trim($fullName));
        return $nameParts[0] ?? 'Unknown';
    }

    /**
     * Extract last name from full name
     */
    private function extractLastName($fullName): string
    {
        if (empty($fullName)) {
            return 'Unknown';
        }

        $nameParts = explode(' ', trim($fullName));
        if (count($nameParts) > 1) {
            return implode(' ', array_slice($nameParts, 1));
        }
        
        return 'Unknown';
    }
}
