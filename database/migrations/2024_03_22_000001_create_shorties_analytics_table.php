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
        Schema::create('shorties_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('shorties_url_id')->constrained();
            $table->dateTime('visited_at');
            $table->string('fingerprint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shorties_analytics');
    }
};
