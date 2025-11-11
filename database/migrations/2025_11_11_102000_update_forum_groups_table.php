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
        Schema::table('forum_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_groups', 'owner_id')) {
                $table->foreignId('owner_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('forum_groups', 'rules')) {
                $table->text('rules')->nullable()->after('description');
            }

            if (!Schema::hasColumn('forum_groups', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('rules');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_groups', function (Blueprint $table) {
            if (Schema::hasColumn('forum_groups', 'owner_id')) {
                $table->dropForeign(['owner_id']);
                $table->dropColumn('owner_id');
            }
            if (Schema::hasColumn('forum_groups', 'rules')) {
                $table->dropColumn('rules');
            }
            if (Schema::hasColumn('forum_groups', 'cover_image')) {
                $table->dropColumn('cover_image');
            }
        });
    }
};

