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
        Schema::create('craigslist_post_tasks', function (Blueprint $table) {
            $table->id();

            $table->date('scheduled_start_date');
            $table->date('scheduled_end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('posts_quantity');
            $table->enum('schedule_type', ['random', 'days', 'time']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craigslist_post_tasks');
    }
};
