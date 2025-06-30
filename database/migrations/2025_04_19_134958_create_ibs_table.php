<?php
// database/migrations/2025_04_19_000006_create_ibs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ibs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('commission_rate', 5, 2);
            $table->string('referral_code', 50)->unique();
            $table->unsignedInteger('total_referred')->default(0);
            $table->decimal('earnings', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibs');
    }
};
