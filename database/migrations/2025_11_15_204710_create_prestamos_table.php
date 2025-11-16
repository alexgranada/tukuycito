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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
            $table->string('estado', 20)->default('prestado');
            $table->text('observaciones')->nullable();
            $table->string('numero_acta')->nullable();
            $table->text('acta')->nullable();
            $table->string('tipo_prestamo')->default('temporal');
            $table->foreignId('almacen_id')->constrained('almacens')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
