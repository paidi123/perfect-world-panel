<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_balances', function (Blueprint $table) {
            $table->id();
            $table->string('balance_type'); // exp_rate, drop_rate, money_rate, etc.
            $table->string('balance_key')->unique();
            $table->float('value');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('balance_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_balances');
    }
};
