<?php

namespace App\Http\Controllers;

use App\Models\Afiliado;
use App\Http\Requests\StoreAfiliadoRequest;
use App\Http\Requests\UpdateAfiliadoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AfiliadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Afiliado::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('ci', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $afiliados = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('afiliados.index', compact('afiliados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('afiliados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAfiliadoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('afiliados', 'public');
        }

        Afiliado::create($data);

        return redirect()->route('afiliados.index')
            ->with('success', 'Afiliado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Afiliado $afiliado)
    {
        $afiliado->load(['vehiculos', 'hojasRuta', 'pagos', 'sanciones', 'asistencias']);
        return view('afiliados.show', compact('afiliado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Afiliado $afiliado)
    {
        return view('afiliados.edit', compact('afiliado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAfiliadoRequest $request, Afiliado $afiliado)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($afiliado->foto) {
                Storage::disk('public')->delete($afiliado->foto);
            }
            $data['foto'] = $request->file('foto')->store('afiliados', 'public');
        }

        $afiliado->update($data);

        return redirect()->route('afiliados.index')
            ->with('success', 'Afiliado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Afiliado $afiliado)
    {
        if ($afiliado->foto) {
            Storage::disk('public')->delete($afiliado->foto);
        }

        $afiliado->delete();

        return redirect()->route('afiliados.index')
            ->with('success', 'Afiliado eliminado exitosamente.');
    }
}
