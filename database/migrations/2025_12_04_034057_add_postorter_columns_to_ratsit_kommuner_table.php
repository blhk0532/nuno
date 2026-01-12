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
        Schema::table('ratsit_kommuner', function (Blueprint $table) {
            $table->json('personer_postorter')->nullable()->after('personer_link');
            $table->json('foretag_postorter')->nullable()->after('foretag_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratsit_kommuner', function (Blueprint $table) {
            $table->dropColumn(['personer_postorter', 'foretag_postorter']);
        });
    }
};
