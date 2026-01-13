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
        //    $table->json('whatsapp_numbers')->nullable()->after('secret_address_ical');
        //    $table->string('shareable_link')->nullable()->after('whatsapp_numbers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_numbers', 'shareable_link']);
        });
    }
};
