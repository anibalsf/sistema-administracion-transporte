<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Http\Requests\StoreRutaRequest;
use App\Http\Requests\UpdateRutaRequest;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruta::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('origen', 'like', "%{$search}%")
                  ->orWhere('destino', 'like', "%{$search}%");
            });
        }

        $rutas = $query->orderBy('nombre')->paginate(10);
        
        return view('rutas.index', compact('rutas'));
    }

    public function create()
    {
        return view('rutas.create');
    }

    public function store(StoreRutaRequest $request)
    {
        Ruta::create($request->validated());

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta creada exitosamente.');
    }

    public function show(Ruta $ruta)
    {
        $ruta->load(['hojasRuta', 'reservas']);
        return view('rutas.show', compact('ruta'));
    }

    public function edit(Ruta $ruta)
    {
        return view('rutas.edit', compact('ruta'));
    }

    public function update(UpdateRutaRequest $request, Ruta $ruta)
    {
        $ruta->update($request->validated());

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta actualizada exitosamente.');
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta eliminada exitosamente.');
    }
}
