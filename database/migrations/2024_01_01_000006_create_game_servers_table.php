<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_servers', function (Blueprint $table) {
            $table->id();
            $table->string('server_name')->unique();
            $table->string('server_ip');
            $table->integer('server_port');
            $table->enum('status', ['online', 'offline', 'maintenance'])->default('online');
            $table->integer('max_players')->default(500);
            $table->integer('current_players')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->dateTime('last_restart')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_servers');
    }
};
