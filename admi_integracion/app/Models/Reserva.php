<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'ruta_id',
        'vehiculo_id',
        'nombre_pasajero',
        'telefono',
        'fecha_reserva',
        'fecha_viaje',
        'numero_asientos',
        'estado',
    ];

    protected $casts = [
        'fecha_reserva' => 'datetime',
        'fecha_viaje' => 'date',
    ];

    /**
     * Get the ruta that owns the reserva.
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }

    /**
     * Get the vehiculo that owns the reserva.
     */
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
