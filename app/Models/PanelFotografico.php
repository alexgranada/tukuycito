<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelFotografico extends Model
{
    protected $table = 'panel_fotografico';

    protected $fillable = [
        'fecha',
        'n_guia',
        'precinto',
        'placa',
        'estado',
        'usuario_id',
        'tipo',
        'oc',
        'producto_id',
        'ubicacion',
        'observaciones'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function fotos()
    {
        return $this->hasMany(PanelFoto::class, 'panelfotografico_id');
    }
}
