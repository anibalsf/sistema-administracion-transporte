<?php

namespace App\Http\Controllers;

use App\Models\Afiliado;
use App\Models\Vehiculo;
use App\Models\Ruta;
use App\Models\HojaRuta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAfiliados = Afiliado::where('estado', 'activo')->count();
        $totalVehiculos = Vehiculo::where('estado', 'activo')->count();
        $totalRutas = Ruta::where('estado', 'activa')->count();
        
        $hojasRutaRecientes = HojaRuta::with(['afiliado', 'vehiculo', 'ruta'])
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalAfiliados',
            'totalVehiculos',
            'totalRutas',
            'hojasRutaRecientes'
        ));
    }
}
