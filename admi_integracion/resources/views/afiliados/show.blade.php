<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-700">SINDICATO MIXTO INTEGRACIÓN TAIPIPLAYA</h1>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="max-w-6xl mx-auto">
                    <!-- Header with Actions -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Detalles del Afiliado</h2>
                            <p class="text-gray-600 mt-1">Información completa del afiliado</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('afiliados.edit', $afiliado) }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                                Editar
                            </a>
                            <a href="{{ route('afiliados.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Volver
                            </a>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Información Personal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if($afiliado->foto)
                            <div class="md:col-span-3 flex justify-center">
                                <img src="{{ Storage::url($afiliado->foto) }}" alt="Foto" class="h-40 w-40 object-cover rounded-full border-4 border-teal-600">
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-500">CI</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->ci }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nombres</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->nombres }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Apellidos</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->apellidos }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Fecha de Nacimiento</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->fecha_nacimiento->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Teléfono</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->telefono }}</p>
                            </div>

                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-500">Dirección</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->direccion }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Fecha de Afiliación</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $afiliado->fecha_afiliacion->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Estado</label>
                                <span class="mt-1 inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $afiliado->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($afiliado->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                            <p class="text-sm text-gray-600 font-medium">Vehículos</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $afiliado->vehiculos->count() }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                            <p class="text-sm text-gray-600 font-medium">Hojas de Ruta</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $afiliado->hojasRuta->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                            <p class="text-sm text-gray-600 font-medium">Pagos</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $afiliado->pagos->count() }}</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                            <p class="text-sm text-gray-600 font-medium">Sanciones</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $afiliado->sanciones->count() }}</p>
                        </div>
                    </div>

                    <!-- Vehículos -->
                    @if($afiliado->vehiculos->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Vehículos Registrados</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Placa</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Marca</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Modelo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tipo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($afiliado->vehiculos as $vehiculo)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $vehiculo->placa }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $vehiculo->marca }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $vehiculo->modelo }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ ucfirst($vehiculo->tipo) }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $vehiculo->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($vehiculo->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Recent Hojas de Ruta -->
                    @if($afiliado->hojasRuta->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Hojas de Ruta Recientes</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Fecha</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Vehículo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Ruta</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($afiliado->hojasRuta->take(5) as $hoja)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $hoja->fecha->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $hoja->vehiculo->placa }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $hoja->ruta->nombre }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">Bs. {{ number_format($hoja->monto, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
