<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoDetalle extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'prestamo_detalles';

    /**
     * Deshabilitar timestamps si no los tienes (created_at, updated_at).
     * Si SÍ los tienes, comenta o elimina esta línea.
     */
    public $timestamps = false;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prestamo_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'user_id', // El usuario que registra el detalle
    ];

    /**
     * Relación: Un detalle pertenece a un Préstamo.
     */
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    /**
     * Relación: Un detalle pertenece a un Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación: Un detalle es registrado por un Usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}