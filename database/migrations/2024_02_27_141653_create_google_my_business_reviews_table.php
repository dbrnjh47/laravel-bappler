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
        Schema::create('google_my_business_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('google_my_business_point_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('date_published', 30);
            $table->float('stars', 3,1);
            $table->text('text');
            //$table->string('images')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_my_business_reviews');
    }
};
