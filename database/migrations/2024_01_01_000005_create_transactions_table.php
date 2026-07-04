<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->enum('transaction_type', ['topup', 'purchase', 'transfer', 'reward', 'refund', 'adjustment'])->default('topup');
            $table->decimal('amount', 15, 2);
            $table->enum('currency_type', ['yuanBao', 'money', 'point'])->default('yuanBao');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('reference_id')->nullable()->unique();
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();
            $table->index('account_id');
            $table->index('transaction_type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
