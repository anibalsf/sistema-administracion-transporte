<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'afiliado_id',
        'placa',
        'marca',
        'modelo',
        'anio',
        'color',
        'tipo',
        'capacidad',
        'estado',
        'foto',
    ];

    /**
     * Get the afiliado that owns the vehiculo.
     */
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    /**
     * Get the hojas de ruta for the vehiculo.
     */
    public function hojasRuta()
    {
        return $this->hasMany(HojaRuta::class);
    }

    /**
     * Get the reservas for the vehiculo.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
