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
        // Avatar URL column already exists in users table via config
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('avatar_url')->nullable()->after('email');
        // });
    }

    public function down(): void
    {
        // Don't drop avatar_url as it was created by the main users migration
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('avatar_url');
        // });
    }
};
