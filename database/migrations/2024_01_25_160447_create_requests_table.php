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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained()->cascadeOnDelete();
            //IP address both for IPv4 and IPv6
            $table->string('ip_address', 46);
            $table->string('http_user_agent', 255);
            $table->string('http_user_language');
            $table->string('country')->default('');
            $table->string('region')->default('');
            $table->string('city')->default('');
            $table->string('hostname')->default('');
            $table->string('ISP')->default('');
            $table->string('ASN')->default('');
            $table->string('organization')->default('');
            $table->string('timezone')->default('');
            $table->decimal('latitude', 10, 8)->default(0.0);
            $table->decimal('longitude', 11, 8)->default(0.0);
            $table->boolean('is_crawler')->default(false);
            $table->boolean('is_proxy')->default(false);
            $table->boolean('is_vpn')->default(false);
            $table->boolean('is_tor')->default(false);
            $table->integer('fraud_score')->default(0);
            $table->string('keyword')->default('');
            $table->string('search_term')->default('');
            $table->decimal('cost', 10,2)->default(0);
            $table->json('UTM');
            //Flag is show that data from ipqualityscore already was received
            $table->boolean('is_fill_ipqualityscore')->default(false);
            //Flag is show that data from ads.google.com already was received
            $table->boolean('is_fill_adsgoogle')->default(false);
            $table->timestamps();

            $table->index('is_fill_ipqualityscore');
            $table->index('is_fill_adsgoogle');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
