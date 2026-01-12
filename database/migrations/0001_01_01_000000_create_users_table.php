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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('role')->default('user');
            $table->foreignId('type_id')->nullable()->constrained('user_types')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('name_first')->nullable();
            $table->string('name_last')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('email_private')->nullable();
            $table->string('phone')->nullable();
            $table->string('team')->nullable();
            $table->string('phone_private')->nullable();
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
            $table->foreignId('current_team_id')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
