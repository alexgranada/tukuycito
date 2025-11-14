<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelFoto extends Model
{
    protected $table = 'panel_fotos';

    protected $fillable = [
        'panelfotografico_id',
        'foto',
        'fecha',
        'usuario_id',
        'descripcion'
    ];

    // Relaciones
    public function panel()
    {
        return $this->belongsTo(PanelFotografico::class, 'panelfotografico_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
