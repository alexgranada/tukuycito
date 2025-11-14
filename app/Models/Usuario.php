<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'almacen_id',
        'tipo',
        'correo',
        'clave'
    ];

    protected $hidden = ['clave'];

    // Relaciones
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function devengados()
    {
        return $this->hasMany(Devengado::class);
    }

    public function panelesFotograficos()
    {
        return $this->hasMany(PanelFotografico::class);
    }

    public function fotosPanel()
    {
        return $this->hasMany(PanelFoto::class);
    }
}
