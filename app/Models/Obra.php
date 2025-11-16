<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $table = 'obras';
    protected $fillable = [
        'nombre',
        'meta',
        'responsable',
        'telefono',
        'ubicacion',
    ];
}
