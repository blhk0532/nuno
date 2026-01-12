<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_nums', function (Blueprint $table) {
            $table->integer('hitta_postort_total_pages')->nullable()->after('hitta_personer_queue');
            $table->integer('hitta_postort_processed_pages')->default(0)->after('hitta_postort_total_pages');
            $table->integer('hitta_postort_last_page')->nullable()->after('hitta_postort_processed_pages');
        });
    }

    public function down(): void
    {
        Schema::table('post_nums', function (Blueprint $table) {
            $table->dropColumn([
                'hitta_postort_total_pages',
                'hitta_postort_processed_pages',
                'hitta_postort_last_page',
            ]);
        });
    }
};
