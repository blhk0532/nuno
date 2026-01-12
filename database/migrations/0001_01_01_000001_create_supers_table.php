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
        Schema::create('supers', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('role')->default('super');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->string(config('filament-edit-profile.avatar_column', 'avatar_url'))->nullable();
            $table->json('custom_fields')->nullable();
            $table->string(config('filament-edit-profile.locale_column', 'locale'))->nullable();
            $table->string(config('filament-edit-profile.theme_color_column', 'theme_color'))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supers');
    }
};
