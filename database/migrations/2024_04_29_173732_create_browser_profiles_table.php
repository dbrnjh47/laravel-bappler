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
        Schema::create('browser_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->index();
            $table->string('name');
            $table->string('user_name')->nullable();
            $table->string('domain_name')->nullable();

            $table->unsignedBigInteger('browser_group_id')->nullable();
            $table->unsignedBigInteger('proxy_id')->nullable();

            $table->timestamp('profil_created_at')->nullable();
            $table->timestamp('last_open_at')->nullable();

            $table->foreign('browser_group_id')->references('id')->on('browser_groups')->onDelete('cascade');
            $table->foreign('proxy_id')->references('id')->on('proxies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('browser_profiles');
    }
};
