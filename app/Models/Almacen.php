<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacens';

    protected $fillable = ['nombre'];

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function devengados()
    {
        return $this->hasMany(Devengado::class);
    }
}
