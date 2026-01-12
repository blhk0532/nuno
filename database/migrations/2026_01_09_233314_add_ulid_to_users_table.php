<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'ulid')) {
            Schema::table('users', function (Blueprint $table) {
                $table->char('ulid', 26)->nullable()->after('id');
            });
        }

        // Populate existing users with ULID
        $users = DB::table('users')->whereNull('ulid')->get();
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)->update(['ulid' => (string) \Illuminate\Support\Str::ulid()]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('ulid');
            $table->char('ulid', 26)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['ulid']);
            $table->dropColumn('ulid');
        });
    }
};
