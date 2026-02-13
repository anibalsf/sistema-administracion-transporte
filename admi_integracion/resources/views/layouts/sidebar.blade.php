<div class="w-64 bg-teal-700 min-h-screen shadow-lg">
    <nav class="mt-6">
        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('dashboard') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('afiliados.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('afiliados.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Afiliados
        </a>
        <a href="{{ route('vehiculos.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('vehiculos.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
            </svg>
            Vehículos
        </a>
        <a href="{{ route('rutas.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('rutas.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            Rutas
        </a>
        <a href="{{ route('hojas-ruta.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('hojas-ruta.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Hojas de Ruta
        </a>
        <a href="{{ route('pagos.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('pagos.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Pagos
        </a>
        <a href="{{ route('reservas.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('reservas.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Reservas
        </a>
        <a href="{{ route('sanciones.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('sanciones.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Sanciones
        </a>
        <a href="{{ route('asistencias.index') }}" class="flex items-center px-6 py-3 text-white {{ request()->routeIs('asistencias.*') ? 'bg-teal-600 border-l-4 border-teal-400' : 'hover:bg-teal-600' }} transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Asistencia
        </a>
    </nav>
</div>
