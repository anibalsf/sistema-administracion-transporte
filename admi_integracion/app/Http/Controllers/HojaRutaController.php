<?php

namespace App\Http\Controllers;

use App\Models\HojaRuta;
use App\Models\Afiliado;
use App\Models\Vehiculo;
use App\Models\Ruta;
use App\Http\Requests\StoreHojaRutaRequest;
use App\Http\Requests\UpdateHojaRutaRequest;
use Illuminate\Http\Request;

class HojaRutaController extends Controller
{
    public function index(Request $request)
    {
        $query = HojaRuta::with(['afiliado', 'vehiculo', 'ruta']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('afiliado', function($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%");
                })
                ->orWhereHas('vehiculo', function($q) use ($search) {
                    $q->where('placa', 'like', "%{$search}%");
                })
                ->orWhereHas('ruta', function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                });
            });
        }

        $hojasRuta = $query->orderBy('fecha', 'desc')->paginate(10);
        
        return view('hojas-ruta.index', compact('hojasRuta'));
    }

    public function create()
    {
        $afiliados = Afiliado::where('estado', 'activo')->orderBy('nombres')->get();
        $vehiculos = Vehiculo::where('estado', 'activo')->with('afiliado')->orderBy('placa')->get();
        $rutas = Ruta::where('estado', 'activa')->orderBy('nombre')->get();
        
        return view('hojas-ruta.create', compact('afiliados', 'vehiculos', 'rutas'));
    }

    public function store(StoreHojaRutaRequest $request)
    {
        HojaRuta::create($request->validated());

        return redirect()->route('hojas-ruta.index')
            ->with('success', 'Hoja de ruta creada exitosamente.');
    }

    public function show(HojaRuta $hojasRutum)
    {
        $hojasRutum->load(['afiliado', 'vehiculo', 'ruta']);
        return view('hojas-ruta.show', compact('hojasRutum'));
    }

    public function edit(HojaRuta $hojasRutum)
    {
        $afiliados = Afiliado::where('estado', 'activo')->orderBy('nombres')->get();
        $vehiculos = Vehiculo::where('estado', 'activo')->with('afiliado')->orderBy('placa')->get();
        $rutas = Ruta::where('estado', 'activa')->orderBy('nombre')->get();
        
        return view('hojas-ruta.edit', compact('hojasRutum', 'afiliados', 'vehiculos', 'rutas'));
    }

    public function update(UpdateHojaRutaRequest $request, HojaRuta $hojasRutum)
    {
        $hojasRutum->update($request->validated());

        return redirect()->route('hojas-ruta.index')
            ->with('success', 'Hoja de ruta actualizada exitosamente.');
    }

    public function destroy(HojaRuta $hojasRutum)
    {
        $hojasRutum->delete();

        return redirect()->route('hojas-ruta.index')
            ->with('success', 'Hoja de ruta eliminada exitosamente.');
    }
}
