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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados')->onDelete('cascade');
            $table->string('placa', 20)->unique();
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->year('anio');
            $table->string('color', 30);
            $table->enum('tipo', ['minibus', 'taxi', 'trufi']);
            $table->integer('capacidad');
            $table->enum('estado', ['activo', 'mantenimiento', 'inactivo'])->default('activo');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
