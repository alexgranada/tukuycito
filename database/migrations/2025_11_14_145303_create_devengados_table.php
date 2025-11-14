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
        Schema::create('devengados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('almacen_id')->constrained('almacens');
            $table->string('oc')->nullable();
            $table->string('siaf')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio_total', 12, 2)->default(0);
            $table->string('estado')->default('pendiente');
            $table->foreignId('usuario_id')->constrained('users');
            $table->text('observaciones')->nullable();
            $table->string('proveedor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devengados');
    }
};
