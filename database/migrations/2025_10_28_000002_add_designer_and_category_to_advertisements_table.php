<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add columns first
        if (!Schema::hasColumn('advertisements', 'designer_id')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->unsignedBigInteger('designer_id')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('advertisements', 'category_id')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->unsignedBigInteger('category_id')->nullable()->after('designer_id');
            });
        }

        if (!Schema::hasColumn('advertisements', 'description')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }

        if (DB::getDriverName() === 'mysql') {
            // Try to add foreign keys, but skip if they already exist
            try {
                DB::statement('ALTER TABLE `advertisements` ADD CONSTRAINT `advertisements_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL');
            } catch (\Exception $e) {
                // Constraint might already exist
            }

            try {
                DB::statement('ALTER TABLE `advertisements` ADD CONSTRAINT `advertisements_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL');
            } catch (\Exception $e) {
                // Constraint might already exist
            }
        } else {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->foreign('designer_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            if (Schema::hasColumn('advertisements', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('advertisements', 'designer_id')) {
                $table->dropForeign(['designer_id']);
                $table->dropColumn('designer_id');
            }
            if (Schema::hasColumn('advertisements', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};