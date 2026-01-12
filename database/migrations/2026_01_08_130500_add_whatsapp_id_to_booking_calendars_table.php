<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table): void {
            if (! Schema::hasColumn('booking_calendars', 'whatsapp_id')) {
                $table->foreignUuid('whatsapp_id')
                    ->nullable()
                    ->after('google_calendar_id')
                    ->constrained('whatsapp_instances')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table): void {
            if (Schema::hasColumn('booking_calendars', 'whatsapp_id')) {
                $table->dropConstrainedForeignId('whatsapp_id');
            }
        });
    }
};
