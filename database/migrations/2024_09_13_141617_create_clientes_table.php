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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id');
            $table->string('nro_cliente', 191)->nullable();
            $table->string('razon_social', 191)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('calle', 191)->nullable();
            $table->string('numero', 191)->nullable();
            $table->string('localidad', 191)->nullable();
            $table->string('provincia', 191)->nullable();
            $table->string('pais', 191)->nullable();
            $table->decimal('latitud', 15, 7)->nullable();
            $table->decimal('longitud', 15, 7)->nullable();
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fin')->nullable();
            $table->integer('tiempo_servicio')->nullable();
            $table->string('tipo', 191)->nullable();
            $table->string('zona', 191)->nullable();
            $table->text('zona')->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('correo', 191)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
