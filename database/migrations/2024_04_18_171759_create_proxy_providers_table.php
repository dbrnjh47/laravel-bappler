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
        Schema::create('proxy_providers', function (Blueprint $table) {
            $table->id();

            $table->string('login');
            $table->string('email');

            $table->enum('name', ['proxy_cheap']);
            $table->unsignedDecimal('balance')->default(0);
            $table->string('api_key', 255);
            $table->string('secret_key', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_providers');
    }
};
