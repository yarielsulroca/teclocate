<?php

use Illuminate\Container\Attributes\DB;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('nro_ticket')->unique();
            $table->foreignId('tecnico_id')->constrained()->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');

            $table->string('descripcion')->nullable();
            $table->boolean('terminado')->default(false);
            $table->string('prioridad')->nullable();
            $table->timestamp('fecha_asignacion');
            $table->timestamp('fecha_solucion')->nullable();
            $table->string('estado')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
