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
        Schema::table('post_news', function (Blueprint $table) {
            $table->unsignedSmallInteger('reading_time')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('post_news', function (Blueprint $table) {
            $table->dropColumn('reading_time');
        });
    }
};
