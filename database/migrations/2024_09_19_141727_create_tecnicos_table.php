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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('zona')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropUnique(['nombre', 'phone']);
        });
    }
};
