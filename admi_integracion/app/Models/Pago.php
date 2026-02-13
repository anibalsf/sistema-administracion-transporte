<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'afiliado_id',
        'tipo',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'comprobante',
        'estado',
        'descripcion',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Get the afiliado that owns the pago.
     */
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }
}
