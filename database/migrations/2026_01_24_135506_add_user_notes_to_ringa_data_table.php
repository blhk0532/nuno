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
            $table->text('user_notes')->nullable()->after('booked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ringa_data', function (Blueprint $table) {
            $table->dropColumn('user_notes');
        });
    }
};
