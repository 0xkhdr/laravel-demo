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
        Schema::create('cache_metrics', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hit', 'miss', 'invalidation'])->index();
            $table->string('cache_key')->index();
            $table->integer('duration_ms')->default(0);
            $table->timestamp('created_at')->nullable();

            // Add index for common queries
            $table->index(['type', 'created_at']);
            $table->index(['cache_key', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache_metrics');
    }
};
