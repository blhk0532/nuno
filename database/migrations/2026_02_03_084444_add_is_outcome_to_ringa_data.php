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
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        Schema::table('ringa_data', function (Blueprint $table) {
            $table->boolean('is_outcome')->default(false)->after('outcome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        Schema::table('ringa_data', function (Blueprint $table) {
            $table->dropColumn('is_outcome');
        });
    }
};
