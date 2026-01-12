<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratsit_streets', function (Blueprint $table) {
            $table->id();
            $table->string('street_name');
            $table->integer('person_count');
            $table->string('postal_code');
            $table->string('city');
            $table->text('url');
            $table->timestamp('scraped_at');
            $table->timestamps();

            $table->unique(['street_name', 'postal_code']);
            $table->index('postal_code');
        });

        Schema::create('ratsit_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('street');
            $table->string('postal_code');
            $table->string('city');
            $table->text('url');
            $table->timestamp('scraped_at');
            $table->timestamps();

            $table->unique(['name', 'postal_code', 'street']);
            $table->index('postal_code');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratsit_streets');
        Schema::dropIfExists('ratsit_persons');
    }
};
