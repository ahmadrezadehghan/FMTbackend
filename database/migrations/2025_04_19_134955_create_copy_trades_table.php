<?php
// database/migrations/2025_04_19_000011_create_copy_trades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('copy_trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->enum('copying_mode', ['proportional','fixed']);
            $table->decimal('fee_percentage', 5, 2)->nullable();
            $table->enum('status', ['active','stopped'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('copy_trades');
    }
};
