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
        if (! Schema::hasColumn('teams', 'ulid')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->char('ulid', 26)->nullable()->after('id');
            });
        }

        // Populate existing teams with ULID
        $teams = DB::table('teams')->whereNull('ulid')->get();
        foreach ($teams as $team) {
            DB::table('teams')->where('id', $team->id)->update(['ulid' => (string) \Illuminate\Support\Str::ulid()]);
        }

        Schema::table('teams', function (Blueprint $table) {
            $table->unique('ulid');
            $table->char('ulid', 26)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropUnique(['ulid']);
            $table->dropColumn('ulid');
        });
    }
};
