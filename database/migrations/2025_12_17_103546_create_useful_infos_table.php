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
        Schema::create('useful_infos', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'prayer_times', 'university_contact', 'pharmacy_on_duty', 'campus_map'
            $table->string('title');
            $table->text('content')->nullable();
            $table->json('data')->nullable(); // Pour stocker les heures de prière, contacts, etc.
            $table->string('image')->nullable(); // Pour pharmacie de garde et plan du campus
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Ambassadeur qui a modifié
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_infos');
    }
};
