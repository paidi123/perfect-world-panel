<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->enum('event_type', ['global', 'pvp', 'dungeon', 'seasonal', 'limited'])->default('global');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('reward_item_id')->nullable()->constrained('items')->onDelete('set null');
            $table->integer('reward_quantity')->default(1);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            $table->index('event_type');
            $table->index('is_active');
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_events');
    }
};
