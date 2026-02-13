<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sancion extends Model
{
    protected $table = 'sanciones';

    protected $fillable = [
        'afiliado_id',
        'tipo',
        'descripcion',
        'monto',
        'fecha_sancion',
        'fecha_vencimiento',
        'estado',
    ];

    protected $casts = [
        'fecha_sancion' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Get the afiliado that owns the sancion.
     */
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }
}
