<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->string('character_name')->unique();
            $table->integer('level')->default(1);
            $table->enum('class', ['wizard', 'warrior', 'archer', 'cleric', 'assassin'])->nullable();
            $table->enum('faction', ['human', 'tian', 'demon'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->bigInteger('experience')->default(0);
            $table->decimal('money', 20, 2)->default(0);
            $table->integer('yuanBao')->default(0);
            $table->integer('boundYuanBao')->default(0);
            $table->enum('status', ['online', 'offline'])->default('offline');
            $table->dateTime('last_login')->nullable();
            $table->integer('play_time')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('account_id');
            $table->index('character_name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
