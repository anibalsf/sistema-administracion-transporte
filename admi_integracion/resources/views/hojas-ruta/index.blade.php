<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-700">SINDICATO MIXTO INTEGRACIÓN TAIPIPLAYA</h1>
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>

        <div class="flex">
            @include('layouts.sidebar')

            <div class="flex-1 p-8">
                @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Hojas de Ruta</h2>
                    <a href="{{ route('hojas-ruta.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nueva Hoja de Ruta
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-4">
                    <form action="{{ route('hojas-ruta.index') }}" method="GET" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por afiliado, vehículo o ruta..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg">Buscar</button>
                        @if(request('search'))
                        <a href="{{ route('hojas-ruta.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">Limpiar</a>
                        @endif
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Afiliado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Vehículo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Ruta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Monto (Bs.)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($hojasRuta as $hoja)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $hoja->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $hoja->afiliado->nombres }} {{ $hoja->afiliado->apellidos }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $hoja->vehiculo->placa }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $hoja->ruta->nombre }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $hoja->fecha->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($hoja->monto, 2) }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('hojas-ruta.show', $hoja) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('hojas-ruta.edit', $hoja) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('hojas-ruta.destroy', $hoja) }}" method="POST" onsubmit="return confirm('¿Eliminar esta hoja de ruta?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No se encontraron hojas de ruta.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $hojasRuta->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
