<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ringa_data', function (Blueprint $table): void {
            $table->id();

            // Address
            $table->text('gatuadress')->nullable();
            $table->text('postnummer')->nullable();
            $table->text('postort')->nullable();
            $table->text('forsamling')->nullable();
            $table->text('kommun')->nullable();
            $table->text('kommun_ratsit')->nullable();
            $table->text('lan')->nullable();
            $table->text('adressandring')->nullable();

            // Arrays / JSON
            $table->json('telfonnummer')->nullable(); // note: intentional column name per spec

            // Person fields
            $table->text('stjarntacken')->nullable();
            $table->text('fodelsedag')->nullable();
            $table->text('personnummer')->nullable();
            $table->text('alder')->nullable();
            $table->text('kon')->nullable();
            $table->text('civilstand')->nullable();
            $table->text('fornamn')->nullable();
            $table->text('efternamn')->nullable();
            $table->text('personnamn')->nullable();


            // Phones
            $table->text('telefon')->nullable();

            // Emails
            $table->json('epost_adress')->nullable();

            // Dwelling
            $table->text('agandeform')->nullable();
            $table->text('bostadstyp')->nullable();
            $table->text('boarea')->nullable();
            $table->text('byggar')->nullable();
            $table->text('fastighet')->nullable();

            // Collections
            $table->json('personer')->nullable();
            $table->json('foretag')->nullable();
            $table->json('grannar')->nullable();
            $table->json('fordon')->nullable();
            $table->json('hundar')->nullable();
            $table->json('bolagsengagemang')->nullable();

            // Geo / Links
            $table->text('longitude')->nullable();
            $table->text('latitud')->nullable();
            $table->text('google_maps')->nullable();
            $table->text('google_streetview')->nullable();
            $table->text('ratsit_se')->nullable();

            // Flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hus')->default(false);
            $table->boolean('is_telefon')->default(false);
            $table->boolean('is_queued')->default(false);

            $table->text('user_id')->nullable();
            $table->text('service_user_id')->nullable();

            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at')->useCurrent();
            // Timestamps with defaults
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ringa_data');
    }
};
