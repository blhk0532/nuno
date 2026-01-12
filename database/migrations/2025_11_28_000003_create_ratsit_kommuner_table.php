<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratsit_kommuner', function (Blueprint $table) {
            $table->id();
            $table->string('kommun');
            $table->integer('personer_count')->default(0);
            $table->integer('foretag_count')->default(0);
            $table->string('personer_link')->nullable();
            $table->string('foretag_link')->nullable();
            $table->timestamps();

            $table->unique(['kommun']);
            $table->index(['kommun']);
        });

        if (Schema::hasTable('ratsit_person_kommuner')) {
            DB::table('ratsit_person_kommuner')->orderBy('id')->chunkById(1000, function ($rows) {
                $payload = [];
                foreach ($rows as $row) {
                    $payload[] = [
                        'kommun' => $row->kommun,
                        'personer_count' => (int) ($row->person_count ?? 0),
                        'personer_link' => $row->ratsit_link ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (! empty($payload)) {
                    DB::table('ratsit_kommuner')->upsert(
                        $payload,
                        ['kommun'],
                        ['personer_count', 'personer_link', 'updated_at']
                    );
                }
            });
        }

        if (Schema::hasTable('ratsit_foretag_kommuner')) {
            DB::table('ratsit_foretag_kommuner')->orderBy('id')->chunkById(1000, function ($rows) {
                $payload = [];
                foreach ($rows as $row) {
                    $payload[] = [
                        'kommun' => $row->kommun,
                        'foretag_count' => (int) ($row->foretag_count ?? 0),
                        'foretag_link' => $row->ratsit_link ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (! empty($payload)) {
                    DB::table('ratsit_kommuner')->upsert(
                        $payload,
                        ['kommun'],
                        ['foretag_count', 'foretag_link', 'updated_at']
                    );
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ratsit_kommuner');
    }
};
