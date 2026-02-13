<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Afiliado;
use App\Http\Requests\StoreVehiculoRequest;
use App\Http\Requests\UpdateVehiculoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehiculo::with('afiliado');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('placa', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('modelo', 'like', "%{$search}%")
                  ->orWhereHas('afiliado', function($q) use ($search) {
                      $q->where('nombres', 'like', "%{$search}%")
                        ->orWhere('apellidos', 'like', "%{$search}%");
                  });
            });
        }

        $vehiculos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $afiliados = Afiliado::where('estado', 'activo')
            ->orderBy('nombres')
            ->get();
        return view('vehiculos.create', compact('afiliados'));
    }

    public function store(StoreVehiculoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('vehiculos', 'public');
        }

        Vehiculo::create($data);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo creado exitosamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load(['afiliado', 'hojasRuta', 'reservas']);
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $afiliados = Afiliado::where('estado', 'activo')
            ->orderBy('nombres')
            ->get();
        return view('vehiculos.edit', compact('vehiculo', 'afiliados'));
    }

    public function update(UpdateVehiculoRequest $request, Vehiculo $vehiculo)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($vehiculo->foto) {
                Storage::disk('public')->delete($vehiculo->foto);
            }
            $data['foto'] = $request->file('foto')->store('vehiculos', 'public');
        }

        $vehiculo->update($data);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado exitosamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        if ($vehiculo->foto) {
            Storage::disk('public')->delete($vehiculo->foto);
        }

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado exitosamente.');
    }
}
