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
        Schema::create('panel_fotograficos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('n_guia')->nullable();
            $table->string('precinto')->nullable();
            $table->string('placa')->nullable();
            $table->string('estado')->default('activo');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('tipo')->nullable();
            $table->string('oc')->nullable();
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->string('ubicacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panel_fotograficos');
    }
};
