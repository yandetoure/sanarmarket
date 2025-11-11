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
        Schema::table('forum_group_memberships', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_group_memberships', 'status')) {
                $table->string('status', 20)->default('active')->after('role');
                $table->index('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_group_memberships', function (Blueprint $table) {
            if (Schema::hasColumn('forum_group_memberships', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }
        });
    }
};

