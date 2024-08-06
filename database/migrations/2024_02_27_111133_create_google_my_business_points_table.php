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
        Schema::create('google_my_business_points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('address', 500);
            $table->string('open_hours');
            $table->string('phone', 20);
            $table->string('adspower_profile_id', 30);
            $table->string('organization_google_maps_url', 1000)->nullable();
            $table->foreignId('domain_id')->constrained();
            $table->foreignId('email_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_my_business_points');
    }
};
