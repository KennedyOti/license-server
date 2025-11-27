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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropUnique(['api_key']);
            $table->text('api_key')->change();
            $table->text('webhook_secret')->nullable()->change();
            $table->unique('api_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropUnique(['api_key']);
            $table->string('api_key', 64)->unique()->change();
            $table->string('webhook_secret', 64)->nullable()->change();
        });
    }
};
