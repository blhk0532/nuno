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
            $table->unsignedBigInteger('brand_id')->nullable()->after('owner_id');
            $table->json('service_ids')->nullable()->after('brand_id'); // Array of service IDs
            $table->text('notify_emails')->nullable()->after('service_ids'); // Comma separated email addresses

            $table->foreign('brand_id')->references('id')->on('booking_brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id', 'service_ids', 'notify_emails']);
        });
    }
};
