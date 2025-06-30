<?php
// database/migrations/2025_04_20_000016_create_commission_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commission_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('ib_id')->constrained('ibs')->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3);
            $table->dateTime('paid_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_logs');
    }
};
