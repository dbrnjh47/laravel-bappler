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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id');
            $table->foreignId('job_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ad_group_id')->constrained()->cascadeOnDelete();
            $table->dateTime('scheduled');
            $table->decimal('balance_due', 10,2)->default(0);
            $table->decimal('total', 10,2)->default(0);
            $table->decimal('cash', 10,2)->default(0);
            $table->decimal('credit', 10,2)->default(0);
            $table->decimal('checks', 10,2)->default(0);
            $table->decimal('parts', 10,2)->default(0);
            $table->decimal('company_profit', 10,2)->default(0);
            $table->decimal('tech_profit', 10,2)->default(0);
            $table->string('brand')->nullable();
            $table->decimal('service_call_fee', 10,2)->default(0);
            $table->unsignedBigInteger('tech_id');
            $table->foreign('tech_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->index('job_id');
            $table->index('job_type_id');
            $table->index('job_status_id');
            $table->index('ad_group_id');
            $table->index('tech_id');
            $table->index('scheduled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
