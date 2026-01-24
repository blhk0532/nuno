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
        Schema::table('ringa_data', function (Blueprint $table) {
            $table->string('status')->nullable()->after('is_queued');
            $table->string('outcome')->nullable()->after('status');
            $table->integer('attempts')->default(0)->after('outcome');
            $table->unsignedBigInteger('booking_id')->nullable()->after('attempts');
            $table->unsignedBigInteger('calendar_id')->nullable()->after('booking_id');
            $table->timestamp('booked_at')->nullable()->after('calendar_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ringa_data', function (Blueprint $table) {
            $table->dropColumn(['status', 'outcome', 'attempts', 'booking_id', 'calendar_id', 'booked_at']);
        });
    }
};
