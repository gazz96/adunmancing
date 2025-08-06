<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_id'); // YouTube video ID
            $table->string('thumbnail')->nullable(); // Auto from YouTube API or manual
            $table->integer('views_count')->default(0);
            $table->date('published_date')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false); // Featured video for main display
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};