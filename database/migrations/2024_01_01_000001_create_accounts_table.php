<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_name')->unique();
            $table->enum('account_status', ['active', 'inactive', 'suspended'])->default('active');
            $table->dateTime('last_login')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->string('ban_reason')->nullable();
            $table->dateTime('ban_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->index('account_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
