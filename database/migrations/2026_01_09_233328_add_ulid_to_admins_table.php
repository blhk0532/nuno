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
        Schema::table('admins', function (Blueprint $table) {
            $table->char('ulid', 26)->nullable()->after('id');
        });

        // Generate ULID for existing admins
        \App\Models\Admin::all()->each(function ($admin) {
            $admin->update(['ulid' => (string) \Illuminate\Support\Str::ulid()]);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->unique('ulid');
            $table->char('ulid', 26)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropUnique(['ulid']);
            $table->dropColumn('ulid');
        });
    }
};
