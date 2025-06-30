<?php
// database/migrations/2025_04_20_000015_create_trading_accounts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trading_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_number')->unique();
            $table->string('server');
            $table->enum('type', ['demo','real']);
            $table->string('leverage');
            $table->char('base_currency', 3);
            $table->enum('status', ['active','inactive'])->default('active');
            $table->enum('platform', ['mt4','mt5']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_accounts');
    }
};
