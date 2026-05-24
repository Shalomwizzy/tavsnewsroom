<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_news_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->date('viewed_date');
            $table->timestamp('created_at')->useCurrent();

            // One view per IP per post per day
            $table->unique(['post_news_id', 'ip_address', 'viewed_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
