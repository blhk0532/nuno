<?php

declare(strict_types=1);

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
        Schema::create('outcome_delay_settings', function (Blueprint $table) {
            $table->id();
            $table->string('outcome')->unique(); // e.g., "EjFramkopplad", "Upptagen", "Voicemail", "IngetSvar"
            $table->integer('delay_minutes')->default(0); // Delay in minutes
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_active')->default(true); // Enable/disable this outcome delay
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outcome_delay_settings');
    }
};
