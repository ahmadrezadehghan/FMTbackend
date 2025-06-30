<?php
// database/migrations/2025_04_19_000008_create_market_data_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('market_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol', 10);
            $table->decimal('price', 15, 5);
            $table->decimal('bid', 15, 5);
            $table->decimal('ask', 15, 5);
            $table->decimal('volume', 20, 2);
            $table->dateTime('timestamp');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_data');
    }
};
