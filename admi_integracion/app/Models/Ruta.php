<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $fillable = [
        'nombre',
        'origen',
        'destino',
        'distancia_km',
        'tiempo_estimado',
        'tarifa',
        'estado',
        'descripcion',
    ];

    protected $casts = [
        'distancia_km' => 'decimal:2',
        'tarifa' => 'decimal:2',
    ];

    /**
     * Get the hojas de ruta for the ruta.
     */
    public function hojasRuta()
    {
        return $this->hasMany(HojaRuta::class);
    }

    /**
     * Get the reservas for the ruta.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
