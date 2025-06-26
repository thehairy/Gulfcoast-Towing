<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Fahrzeugname (z.B. "Transporter 1")
            $table->string('type'); // Fahrzeugtyp (z.B. "Transporter", "LKW", "PKW")
            $table->string('license_plate')->unique(); // Kennzeichen
            $table->enum('status', ['available', 'in_service', 'maintenance', 'offline'])->default('available');
            $table->text('description')->nullable(); // Beschreibung
            $table->boolean('requires_special_license')->default(false); // Spezielle Lizenz erforderlich
            $table->json('capabilities')->nullable(); // Fähigkeiten als JSON (z.B. ["container", "heavy_load"])
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
