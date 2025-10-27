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
        Schema::table('announcements', function (Blueprint $table) {
            // Supprimer l'ancienne colonne category (string)
            $table->dropColumn('category');
            
            // Ajouter la nouvelle colonne category_id (foreign key)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Modifier la colonne image pour stocker le chemin du fichier
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Supprimer la foreign key
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            
            // Remettre l'ancienne colonne category
            $table->string('category');
        });
    }
};
