<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'codigo',
        'tipo',
        'uni_medida',
        'foto'
    ];

    // Relaciones
    public function panelesFotograficos()
    {
        return $this->hasMany(PanelFotografico::class);
    }
}
