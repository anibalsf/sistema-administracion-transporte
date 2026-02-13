<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'operador']);
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|exists:afiliados,id',
            'placa' => 'required|string|max:20|unique:vehiculos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'anio' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:30',
            'tipo' => 'required|in:minibus,taxi,trufi',
            'capacidad' => 'required|integer|min:1|max:50',
            'estado' => 'required|in:activo,mantenimiento,inactivo',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'afiliado_id.required' => 'Debe seleccionar un afiliado.',
            'afiliado_id.exists' => 'El afiliado seleccionado no existe.',
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Esta placa ya está registrada.',
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'anio.required' => 'El año es obligatorio.',
            'anio.min' => 'El año debe ser mayor a 1900.',
            'anio.max' => 'El año no puede ser mayor al próximo año.',
            'color.required' => 'El color es obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser minibus, taxi o trufi.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
