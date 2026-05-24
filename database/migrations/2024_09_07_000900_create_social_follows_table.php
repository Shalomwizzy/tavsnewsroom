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
        Schema::create('social_follows', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Social media platform (e.g., Facebook, Twitter)
            $table->string('url'); // URL to the social media page
            $table->string('icon_class'); // FontAwesome class for the social media icon
            $table->boolean('is_active')->default(true);
            $table->integer('followers')->default('0'); // Number of followers

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_follows');
    }
};
