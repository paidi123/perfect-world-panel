<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('announcement_type', ['news', 'maintenance', 'event', 'urgent'])->default('news');
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('is_published');
            $table->index('announcement_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
