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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id()->unique();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 15, 7);
            $table->decimal('longitude', 15, 7);
            $table->decimal('long_init')->nullable();
            $table->decimal('long_end')->nullable();
            $table->boolean('comenzada')->default(false);
            $table->boolean('terminada')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
