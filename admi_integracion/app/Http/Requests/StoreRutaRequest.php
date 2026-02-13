<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'operador']);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'origen' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'distancia_km' => 'required|numeric|min:0|max:9999.99',
            'tiempo_estimado' => 'required|integer|min:1',
            'tarifa' => 'required|numeric|min:0|max:9999.99',
            'estado' => 'required|in:activa,inactiva',
            'descripcion' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la ruta es obligatorio.',
            'origen.required' => 'El origen es obligatorio.',
            'destino.required' => 'El destino es obligatorio.',
            'distancia_km.required' => 'La distancia es obligatoria.',
            'tiempo_estimado.required' => 'El tiempo estimado es obligatorio.',
            'tarifa.required' => 'La tarifa es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
