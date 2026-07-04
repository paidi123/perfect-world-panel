<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('reason')->nullable();
            $table->foreignId('distributed_by')->constrained('users')->onDelete('set null');
            $table->dateTime('distributed_at')->nullable();
            $table->timestamps();
            $table->index('account_id');
            $table->index('character_id');
            $table->index('item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_distributions');
    }
};
