<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->unique();
            $table->string('item_name');
            $table->string('item_type');
            $table->enum('item_quality', ['normal', 'uncommon', 'rare', 'epic', 'legendary'])->default('normal');
            $table->integer('level_required')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_tradeable')->default(true);
            $table->boolean('is_stackable')->default(true);
            $table->integer('max_stack')->default(99);
            $table->timestamps();
            $table->softDeletes();
            $table->index('item_type');
            $table->index('item_quality');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
