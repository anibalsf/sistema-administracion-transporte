<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $fillable = [
        'user_id',
        'ci',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'email',
        'fecha_afiliacion',
        'estado',
        'foto',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_afiliacion' => 'date',
    ];

    /**
     * Get the user associated with the afiliado.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vehiculos for the afiliado.
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    /**
     * Get the hojas de ruta for the afiliado.
     */
    public function hojasRuta()
    {
        return $this->hasMany(HojaRuta::class);
    }

    /**
     * Get the pagos for the afiliado.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Get the sanciones for the afiliado.
     */
    public function sanciones()
    {
        return $this->hasMany(Sancion::class);
    }

    /**
     * Get the asistencias for the afiliado.
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
