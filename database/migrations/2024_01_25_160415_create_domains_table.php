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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('namecheap_account');
            $table->integer('namecheap_domain_id');
            $table->string('namecheap_domain_name');
            $table->date('namecheap_created');
            $table->date('namecheap_expires');
            $table->boolean('namecheap_is_expired');
            $table->boolean('namecheap_is_locked');
            $table->boolean('namecheap_is_autorenew');
            $table->timestamps();
            $table->index('namecheap_domain_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
