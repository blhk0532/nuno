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
        Schema::table('booking_calendars', function (Blueprint $table) {
            $table->dropForeign(['notification_user_id']);
            $table->dropColumn('notification_user_id');
            $table->json('notification_user_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table) {
            $table->dropColumn('notification_user_ids');
            $table->foreignId('notification_user_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }
};
