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
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->index();
            $table->unsignedBigInteger('proxy_provider_id');

            $table->boolean('status')->default(false);

            $table->string('network_type');
            $table->string('username')->nullable();
            $table->string('password')->nullable();

            $table->string('proxy_type');

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('provider_created_at')->nullable();

            $table->foreign('proxy_provider_id')->references('id')->on('proxy_providers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxies');
    }
};
