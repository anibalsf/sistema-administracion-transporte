<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'afiliado_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'tipo',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Get the afiliado that owns the asistencia.
     */
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }
}
