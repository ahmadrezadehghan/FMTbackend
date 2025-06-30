<?php
// database/migrations/2025_04_19_000004_create_forex_pairs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('forex_pairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol', 10);
            $table->char('base_currency', 3);
            $table->char('quote_currency', 3);
            $table->decimal('pip_value', 10, 5);
            $table->decimal('min_trade_volume', 10, 2);
            $table->decimal('max_trade_volume', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_pairs');
    }
};
