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
        Schema::create('craig_list_posts', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->index();

            $table->string('title');
            $table->string('preview')->nullable();
            $table->string('city');
            $table->string('zip');
            $table->string('description', 3550);

            $table->enum('email_privacy', ['cl_mail_relay', 'show', 'no_replies']);

            $table->boolean('show_phone')->default(false);
            $table->boolean('phone_calld')->default(false);
            $table->boolean('text_ok')->default(false);

            $table->string('phone_number');
            $table->string('name')->nullable();
            $table->string('extension')->nullable();

            $table->unsignedBigInteger('browser_profile_id');

            $table->timestamp('last_posted_at')->nullable();

            $table->foreign('browser_profile_id')->references('id')->on('browser_profiles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craig_list_posts');
    }
};
