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
        Schema::create('trending_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_news_id')->constrained()->onDelete('cascade');
            $table->string('section'); // Defines the 'section' column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trending_news');
    }
};


