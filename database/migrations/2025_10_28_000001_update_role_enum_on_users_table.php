<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Ensure MySQL enum contains all expected roles
            DB::statement(
                "ALTER TABLE `users` MODIFY `role` ENUM('user','admin','designer','marketing') NOT NULL DEFAULT 'user'"
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Revert to a minimal safe enum (change as needed for your previous state)
            DB::statement(
                "ALTER TABLE `users` MODIFY `role` ENUM('user','admin') NOT NULL DEFAULT 'user'"
            );
        }
    }
};


