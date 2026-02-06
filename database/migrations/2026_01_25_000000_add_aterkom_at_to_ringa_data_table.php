<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        Schema::table('ringa_data', function (Blueprint $table): void {
            $table->timestamp('aterkom_at')->nullable()->after('booked_at');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        Schema::table('ringa_data', function (Blueprint $table): void {
            $table->dropColumn('aterkom_at');
        });
    }
};
