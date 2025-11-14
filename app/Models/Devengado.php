<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devengado extends Model
{
    protected $table = 'devengados';

    protected $fillable = [
        'fecha',
        'almacen_id',
        'oc',
        'siaf',
        'descripcion',
        'precio_total',
        'estado',
        'usuario_id',
        'observaciones',
        'proveedor'
    ];

    // Relaciones
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
