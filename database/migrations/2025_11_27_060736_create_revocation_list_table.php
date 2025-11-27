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
        Schema::create('revocation_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('license_id');
            $table->timestamp('revoked_at');
            $table->timestamps();

            $table->foreign('license_id')->references('id')->on('licenses');
            $table->unique('license_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revocation_list');
    }
};
