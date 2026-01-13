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
            $table->text('public_url')->nullable();
            $table->text('embed_code')->nullable();
            $table->text('public_address_ical')->nullable();
            $table->text('secret_address_ical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_calendars', function (Blueprint $table) {
            $table->dropColumn(['public_url', 'embed_code', 'public_address_ical', 'secret_address_ical']);
        });
    }
};
