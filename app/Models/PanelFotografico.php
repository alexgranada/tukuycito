<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PanelFotografico extends Model
{
    protected $table = 'panel_fotograficos';

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

    public function fotos(): HasMany
    {
        return $this->hasMany(PanelFotos::class, 'panelfotografico_id');
    }
}
