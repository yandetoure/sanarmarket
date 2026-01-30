<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE `users` MODIFY `role` ENUM('user','premium','admin','designer','marketing','ambassador','moderator') NOT NULL DEFAULT 'user'"
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE `users` MODIFY `role` ENUM('user','premium','admin','designer','marketing') NOT NULL DEFAULT 'user'"
            );
        }
    }
};
