<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'prestamos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'obra_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
        'observaciones',
        'numero_acta',
        'acta', // Asumimos que es la ruta del archivo
        'tipo_prestamo',
        'almacen_id',
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion' => 'date',
    ];

    /**
     * Relación: Un préstamo pertenece a un Usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un préstamo pertenece a una Obra.
     */
    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    /**
     * Relación: Un préstamo pertenece a un Almacén.
     */
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    /**
     * Relación: Un préstamo tiene muchos detalles.
     */
    public function detalles()
    {
        return $this->hasMany(PrestamoDetalle::class);
    }
}