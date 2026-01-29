<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert booking-related settings
        $settings = [
            [
                'group' => 'booking',
                'name' => 'booking-leads-timeout',
                'locked' => false,
                'payload' => json_encode(['value' => 300]), // 5 minutes in seconds
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'booking',
                'name' => 'booking-calendar-start-time',
                'locked' => false,
                'payload' => json_encode(['value' => '07:00']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'booking',
                'name' => 'booking-calendar-end-time',
                'locked' => false,
                'payload' => json_encode(['value' => '20:00']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'booking',
                'name' => 'booking-calendar-event-bg-color',
                'locked' => false,
                'payload' => json_encode(['value' => '#3b82f6']), // Blue color
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'booking',
                'name' => 'booking-available-status',
                'locked' => false,
                'payload' => json_encode(['value' => 'available']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            // Use insertOrIgnore to avoid duplicates
            DB::table('settings')->insertOrIgnore($setting);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('name', [
            'booking-leads-timeout',
            'booking-calendar-start-time',
            'booking-calendar-end-time',
            'booking-calendar-event-bg-color',
            'booking-available-status',
        ])->delete();
    }
};
