<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PanelFotos extends Model
{
    protected $table = 'panel_fotos';

    protected $fillable = [
        'panelfotografico_id',
        'foto',
        'fecha',
        'usuario_id',
        'descripcion'
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($foto) {
            // Borra el archivo del storage cuando se elimina el registro
            if ($foto->foto) {
                Storage::delete($foto->foto);
            }
        });
    }

    // Relaciones
    public function panel()
    {
        return $this->belongsTo(PanelFotografico::class, 'panelfotografico_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    public function getUrlAttribute(): string
    {
        return Storage::url($this->foto);
    }
}
