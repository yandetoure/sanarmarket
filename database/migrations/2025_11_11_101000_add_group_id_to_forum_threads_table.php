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
        if (Schema::hasTable('forum_threads') && !Schema::hasColumn('forum_threads', 'group_id')) {
            Schema::table('forum_threads', function (Blueprint $table) {
                $table->foreignId('group_id')
                    ->after('id')
                    ->nullable()
                    ->constrained('forum_groups')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('forum_threads') && Schema::hasColumn('forum_threads', 'group_id')) {
            Schema::table('forum_threads', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }
    }
};

