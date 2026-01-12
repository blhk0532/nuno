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
        // Teams table already exists from earlier migration
        // Schema::create('teams', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->text('description')->nullable();
        //     $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
        //     $table->timestamps();
        // });

        // Team user pivot table - but membership table already exists
        // Schema::create('team_user', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('team_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        //     $table->string('role')->default('member');
        //     $table->timestamps();
        //
        //     $table->unique(['team_id', 'user_id']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('team_user');
        // Schema::dropIfExists('teams'); // Don't drop teams table as it was created by another migration
    }
};
