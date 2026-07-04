<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->nullable()->constrained('characters')->onDelete('set null');
            $table->foreignId('reported_character_id')->nullable()->constrained('characters')->onDelete('set null');
            $table->enum('report_type', ['cheat', 'abuse', 'botting', 'rmt', 'spam', 'other'])->default('other');
            $table->text('report_description');
            $table->text('evidence')->nullable();
            $table->enum('status', ['pending', 'investigating', 'resolved', 'dismissed'])->default('pending');
            $table->foreignId('handled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('action_taken')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();
            $table->index('report_type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_reports');
    }
};
