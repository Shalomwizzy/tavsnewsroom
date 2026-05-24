<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_news', function (Blueprint $table) {
            $table->boolean('is_breaking')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('post_news', function (Blueprint $table) {
            $table->dropColumn('is_breaking');
        });
    }
};
