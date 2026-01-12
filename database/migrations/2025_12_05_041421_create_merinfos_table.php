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
        Schema::create('merinfos', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('short_uuid')->nullable();
            $table->text('name')->nullable();
            $table->text('givenNameOrFirstName')->nullable();
            $table->string('personalNumber')->nullable();
            $table->json('pnr')->nullable();
            $table->json('address')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('is_celebrity')->default(false)->nullable();
            $table->boolean('has_company_engagement')->default(false)->nullable();
            $table->integer('number_plus_count')->default(0)->nullable();
            $table->json('phone_number')->nullable();
            $table->text('url')->nullable();
            $table->text('same_address_url')->nullable();
            $table->timestamps();

            $table->index('short_uuid')->nullable();
            $table->index('personalNumber')->nullable();
            $table->index('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merinfos');
    }
};
