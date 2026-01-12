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
        if (! Schema::hasTable('booking_bookings')) {
            return;
        }

        Schema::table('booking_bookings', function (Blueprint $table): void {
            if (! Schema::hasColumn('booking_bookings', 'schedulable_type')) {
                $table->string('schedulable_type')->nullable()->after('notes');
            }

            if (! Schema::hasColumn('booking_bookings', 'schedulable_id')) {
                $table->unsignedBigInteger('schedulable_id')->nullable()->after('schedulable_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('booking_bookings')) {
            return;
        }

        Schema::table('booking_bookings', function (Blueprint $table): void {
            if (Schema::hasColumn('booking_bookings', 'schedulable_id')) {
                $table->dropColumn('schedulable_id');
            }

            if (Schema::hasColumn('booking_bookings', 'schedulable_type')) {
                $table->dropColumn('schedulable_type');
            }
        });
    }
};
