<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_news', function (Blueprint $table) {
            $table->boolean('ai_generated')->default(false)->after('reading_time');
            $table->unsignedTinyInteger('humanness_score')->nullable()->after('ai_generated');
        });
    }

    public function down(): void
    {
        Schema::table('post_news', function (Blueprint $table) {
            $table->dropColumn(['ai_generated', 'humanness_score']);
        });
    }
};
