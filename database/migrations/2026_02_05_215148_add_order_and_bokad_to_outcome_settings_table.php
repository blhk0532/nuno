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
            $table->unsignedInteger('order')->default(0)->after('aterkom');
            $table->boolean('bokad')->default(false)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outcome_settings', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('bokad');
        });
    }
};
