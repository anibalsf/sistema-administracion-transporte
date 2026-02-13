<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HojaRuta extends Model
{
    protected $table = 'hojas_ruta';

    protected $fillable = [
        'afiliado_id',
        'vehiculo_id',
        'ruta_id',
        'fecha',
        'hora_salida',
        'hora_llegada',
        'monto',
        'pasajeros',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Get the afiliado that owns the hoja de ruta.
     */
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    /**
     * Get the vehiculo that owns the hoja de ruta.
     */
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    /**
     * Get the ruta that owns the hoja de ruta.
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
}
