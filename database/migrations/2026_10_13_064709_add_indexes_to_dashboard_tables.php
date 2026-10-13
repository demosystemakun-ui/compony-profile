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
        // Index untuk tabel News
        Schema::table('news', function (Blueprint $table) {
            $table->index('updated_at');
            $table->index('category');
        });

        // Index untuk tabel Tariffs
        Schema::table('tariffs', function (Blueprint $table) {
            $table->index('updated_at');
            $table->index('sort_order');
        });

        // Index untuk tabel ActivityLogs (jika ada)
        if (Schema::hasTable('activity_logs')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['category']);
        });

        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['sort_order']);
        });

        if (Schema::hasTable('activity_logs')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }
    }
};