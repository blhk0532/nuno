<?php

declare(strict_types=1);

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
        Schema::table('outcome_settings', function (Blueprint $table) {
            $table->unsignedInteger('quarantine_days')->default(0)->after('quarantine');
            $table->boolean('retry')->default(false)->after('max_retry_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outcome_settings', function (Blueprint $table) {
            $table->dropColumn('quarantine_days');
            $table->dropColumn('retry');
        });
    }
};
