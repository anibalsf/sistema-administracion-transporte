<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'operador']);
    }

    public function rules(): array
    {
        $vehiculoId = $this->route('vehiculo');
        
        return [
            'afiliado_id' => 'required|exists:afiliados,id',
            'placa' => ['required', 'string', 'max:20', Rule::unique('vehiculos')->ignore($vehiculoId)],
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
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Esta placa ya está registrada.',
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'anio.required' => 'El año es obligatorio.',
            'color.required' => 'El color es obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
