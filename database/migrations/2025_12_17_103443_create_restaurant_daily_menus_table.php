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
        Schema::create('campus_restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name'); // 'Restau 1' ou 'Restau 2'
            $table->string('meal_type'); // 'dejeuner' ou 'diner'
            $table->text('menu_content'); // Contenu du menu
            $table->date('menu_date');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ambassadeur qui a créé
            $table->timestamps();
            
            // Index unique avec nom personnalisé plus court
            $table->unique(['restaurant_name', 'meal_type', 'menu_date'], 'campus_rest_menu_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_restaurant_menus');
    }
};
