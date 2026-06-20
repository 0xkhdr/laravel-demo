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
        Schema::table('posts', function (Blueprint $table) {
            // Add views column if it doesn't exist
            if (!Schema::hasColumn('posts', 'views')) {
                $table->integer('views')->default(0)->after('body');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the views column if it exists
            if (Schema::hasColumn('posts', 'views')) {
                $table->dropColumn('views');
            }
        });
    }
};
