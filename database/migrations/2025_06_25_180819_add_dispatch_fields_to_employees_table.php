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
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('is_dispatcher')->default(false); // Ist Leitstelle
            $table->enum('duty_status', ['off_duty', 'available', 'in_service', 'busy', 'break', 'out_of_service'])->default('off_duty'); // Dienststatus
            $table->timestamp('duty_started_at')->nullable(); // Dienstbeginn
            $table->text('current_location')->nullable(); // Aktuelle Position/Ort
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['is_dispatcher', 'duty_status', 'duty_started_at', 'current_location']);
        });
    }
};
