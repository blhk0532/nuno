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
        Schema::table('booking_bookings', function (Blueprint $table) {
            $table->string('title')->nullable()->after('number');
            $table->text('description')->nullable()->after('title');
            $table->string('category')->nullable()->after('description');
            $table->string('location')->nullable()->after('category');
            $table->string('color', 32)->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_bookings', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'category', 'location', 'color']);
        });
    }
};
