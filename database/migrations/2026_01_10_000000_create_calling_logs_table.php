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
        Schema::create('calling_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('call_sid')->nullable()->index();
            $table->string('target_number')->nullable()->index();
            $table->string('target_name')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->dateTime('started_at')->nullable()->index();
            $table->dateTime('ended_at')->nullable()->index();
            $table->string('status')->default('initiated')->index();
            $table->string('recording_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calling_logs');
    }
};
