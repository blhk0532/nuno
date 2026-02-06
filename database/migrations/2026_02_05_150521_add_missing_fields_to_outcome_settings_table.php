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
            $table->string('outcome')->nullable()->after('type');
            $table->integer('delay_minutes')->nullable()->after('outcome');
            $table->integer('max_retry_count')->nullable()->after('delay_minutes');
            $table->boolean('quarantine')->default(false)->after('max_retry_count');
            $table->boolean('dmc')->default(false)->after('quarantine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outcome_settings', function (Blueprint $table) {
            $table->dropColumn(['outcome', 'delay_minutes', 'max_retry_count', 'quarantine', 'dmc']);
        });
    }
};
