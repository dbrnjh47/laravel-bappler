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
        Schema::table('craig_list_posts', function (Blueprint $table) {
            $table->dropForeign(['browser_profile_id']);
         });

        Schema::rename("craig_list_posts", "craigslist_posts");

        Schema::table('craigslist_posts', function (Blueprint $table) {
            $table->foreign('browser_profile_id')->references('id')->on('browser_profiles')->onDelete('cascade');
         });

        Schema::dropIfExists('craig_list_posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('craigslist_posts', function (Blueprint $table) {
            $table->dropForeign(['browser_profile_id']);
         });

        Schema::rename("craigslist_posts", "craig_list_posts");

        Schema::table('craig_list_posts', function (Blueprint $table) {
            $table->foreign('browser_profile_id')->references('id')->on('browser_profiles')->onDelete('cascade');
         });

        Schema::dropIfExists('craigslist_posts');
    }
};
