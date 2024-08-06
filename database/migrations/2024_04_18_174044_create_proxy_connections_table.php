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
        Schema::create('proxy_connections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('proxy_id');

            $table->string('public_ip');
            $table->string('connect_ip');
            $table->string('ip_version');
            $table->string('http_port')->nullable();
            $table->string('https_port')->nullable();
            $table->string('socks_5_port')->nullable();

            $table->foreign('proxy_id')->references('id')->on('proxies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_connections');
    }
};
