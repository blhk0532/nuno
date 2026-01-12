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
        Schema::create('carry_data', function (Blueprint $table) {
            $table->id();
            $table->string('person_lopnr')->nullable();
            $table->string('personnr')->nullable();
            $table->string('kon')->nullable();
            $table->string('civilstand')->nullable();
            $table->string('namn')->nullable();
            $table->string('fornamn')->nullable();
            $table->string('efternamn')->nullable();
            $table->string('adress')->nullable();
            $table->string('co_adress')->nullable();
            $table->string('postnr')->nullable();
            $table->string('ort')->nullable();
            $table->string('telefon')->nullable();
            $table->string('mobiltelefon')->nullable();
            $table->string('telefax')->nullable();
            $table->string('epost')->nullable();
            $table->string('epost_privat')->nullable();
            $table->string('epost_sekundar')->nullable();
            $table->boolean('is_hus')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_phone')->nullable();
            $table->boolean('is_epost')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carry_data');
    }
};
