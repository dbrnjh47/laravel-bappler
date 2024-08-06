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
        Schema::create('craigslist_post_templates', function (Blueprint $table) {
            $table->id();

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

            $table->date('posting_start_at');
            $table->date('posting_end_at');

            $table->enum('status', ['scheduled', 'not_active']);
            $table->unsignedBigInteger('browser_profile_id');
            $table->unsignedBigInteger('bank_card_id');

            $table->foreign('browser_profile_id')->references('id')->on('browser_profiles')->onDelete('cascade');
            $table->foreign('bank_card_id')->references('id')->on('bank_cards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craigslist_post_templates');
    }
};
