<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratsit_postorter', function (Blueprint $table) {
            $table->id();
            $table->string('post_ort');
            $table->string('post_nummer');
            $table->integer('personer_count')->default(0);
            $table->integer('foretag_count')->default(0);
            $table->string('personer_link')->nullable();
            $table->string('foretag_link')->nullable();
            $table->timestamps();

            $table->index(['post_ort']);
            $table->index(['post_nummer']);
            $table->unique(['post_ort', 'post_nummer'], 'ratsit_postorter_unique_key');
        });

        if (Schema::hasTable('ratsit_person_postorter')) {
            DB::table('ratsit_person_postorter')->orderBy('id')->chunkById(1000, function ($rows) {
                $payload = [];
                foreach ($rows as $row) {
                    $payload[] = [
                        'post_ort' => $row->post_ort,
                        'post_nummer' => $row->post_nummer,
                        'personer_count' => (int) ($row->person_count ?? 0),
                        'personer_link' => $row->ratsit_link ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (! empty($payload)) {
                    DB::table('ratsit_postorter')->upsert(
                        $payload,
                        ['post_ort', 'post_nummer'],
                        ['personer_count', 'personer_link', 'updated_at']
                    );
                }
            });
        }

        if (Schema::hasTable('ratsit_foretag_postorter')) {
            DB::table('ratsit_foretag_postorter')->orderBy('id')->chunkById(1000, function ($rows) {
                $payload = [];
                foreach ($rows as $row) {
                    $payload[] = [
                        'post_ort' => $row->post_ort,
                        'post_nummer' => $row->post_nummer,
                        'foretag_count' => (int) ($row->foretag_count ?? 0),
                        'foretag_link' => $row->ratsit_link ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (! empty($payload)) {
                    DB::table('ratsit_postorter')->upsert(
                        $payload,
                        ['post_ort', 'post_nummer'],
                        ['foretag_count', 'foretag_link', 'updated_at']
                    );
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ratsit_postorter');
    }
};
