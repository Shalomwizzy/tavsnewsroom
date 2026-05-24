<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_blog_logs', function (Blueprint $table) {
            $table->id();
            $table->text('topic')->nullable();
            $table->string('headline')->nullable();
            $table->string('status')->default('generating');
            $table->unsignedTinyInteger('attempts')->default(1);
            $table->unsignedTinyInteger('humanness_score')->nullable();
            $table->unsignedSmallInteger('word_count')->nullable();
            $table->foreignId('post_news_id')->nullable()->constrained('post_news')->nullOnDelete();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_logs');
    }
};
