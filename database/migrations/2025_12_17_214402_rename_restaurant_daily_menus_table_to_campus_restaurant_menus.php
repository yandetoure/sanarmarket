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
        // Renommer la table si elle existe avec l'ancien nom
        if (Schema::hasTable('restaurant_daily_menus')) {
            Schema::rename('restaurant_daily_menus', 'campus_restaurant_menus');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Renommer la table de retour si elle existe
        if (Schema::hasTable('campus_restaurant_menus')) {
            Schema::rename('campus_restaurant_menus', 'restaurant_daily_menus');
        }
    }
};
