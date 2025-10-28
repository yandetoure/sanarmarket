<?php declare(strict_types=1);

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
        Schema::create('designer_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('logo_path')->nullable();
            
            // Couleurs sidebar
            $table->string('sidebar_bg_color')->default('#ffffff');
            $table->string('sidebar_text_color')->default('#374151');
            $table->string('sidebar_active_bg')->default('#FCE7F3'); // pink-50
            $table->string('sidebar_active_text')->default('#DB2777'); // pink-600
            
            // Couleurs navbar
            $table->string('navbar_bg_color')->default('#ffffff');
            $table->string('navbar_text_color')->default('#111827');
            $table->string('navbar_accent_color')->default('#EC4899'); // pink-500
            
            // Couleurs principales
            $table->string('primary_color')->default('#EC4899'); // pink-500
            $table->string('secondary_color')->default('#A855F7'); // purple-500
            $table->string('accent_color')->default('#F472B6'); // pink-400
            
            // Personnalisation du texte
            $table->string('font_family')->default('Inter');
            $table->integer('font_size')->default(16);
            
            $table->timestamps();
            
            // Un seul paramètre par utilisateur
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designer_settings');
    }
};