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
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('origen', 100);
            $table->string('destino', 100);
            $table->decimal('distancia_km', 8, 2);
            $table->integer('tiempo_estimado'); // en minutos
            $table->decimal('tarifa', 8, 2);
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
