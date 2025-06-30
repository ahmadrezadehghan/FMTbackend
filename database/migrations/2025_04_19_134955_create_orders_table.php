<?php
// database/migrations/2025_04_19_000007_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('order_type', ['market','limit','stop','trailing']);
            $table->string('symbol', 10);
            $table->decimal('volume', 10, 2);
            $table->decimal('price', 15, 5);
            $table->decimal('stop_loss', 15, 5)->nullable();
            $table->decimal('take_profit', 15, 5)->nullable();
            $table->enum('status', ['open','closed','cancelled'])->default('open');
            $table->dateTime('executed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
