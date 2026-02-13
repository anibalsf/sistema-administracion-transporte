<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHojaRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'operador']);
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|exists:afiliados,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'ruta_id' => 'required|exists:rutas,id',
            'fecha' => 'required|date',
            'hora_salida' => 'nullable|date_format:H:i',
            'hora_llegada' => 'nullable|date_format:H:i|after:hora_salida',
            'monto' => 'required|numeric|min:0|max:9999.99',
            'pasajeros' => 'required|integer|min:0|max:100',
            'observaciones' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'afiliado_id.required' => 'Debe seleccionar un afiliado.',
            'vehiculo_id.required' => 'Debe seleccionar un vehículo.',
            'ruta_id.required' => 'Debe seleccionar una ruta.',
            'fecha.required' => 'La fecha es obligatoria.',
            'monto.required' => 'El monto es obligatorio.',
            'pasajeros.required' => 'El número de pasajeros es obligatorio.',
            'hora_llegada.after' => 'La hora de llegada debe ser posterior a la hora de salida.',
        ];
    }
}
