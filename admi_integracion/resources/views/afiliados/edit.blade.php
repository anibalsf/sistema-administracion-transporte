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
                <div class="max-w-4xl mx-auto">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Editar Afiliado</h2>
                        <p class="text-gray-600 mt-1">Modifique los datos del afiliado</p>
                    </div>

                    <!-- Form -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <form action="{{ route('afiliados.update', $afiliado) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- CI -->
                                <div>
                                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">CI *</label>
                                    <input type="text" name="ci" id="ci" value="{{ old('ci', $afiliado->ci) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('ci') border-red-500 @enderror">
                                    @error('ci')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $afiliado->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $afiliado->nombres) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('nombres') border-red-500 @enderror">
                                    @error('nombres')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $afiliado->apellidos) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div>
                                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $afiliado->fecha_nacimiento->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('fecha_nacimiento') border-red-500 @enderror">
                                    @error('fecha_nacimiento')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $afiliado->telefono) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('telefono') border-red-500 @enderror">
                                    @error('telefono')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dirección -->
                                <div class="md:col-span-2">
                                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                                    <textarea name="direccion" id="direccion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $afiliado->direccion) }}</textarea>
                                    @error('direccion')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fecha Afiliación -->
                                <div>
                                    <label for="fecha_afiliacion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Afiliación *</label>
                                    <input type="date" name="fecha_afiliacion" id="fecha_afiliacion" value="{{ old('fecha_afiliacion', $afiliado->fecha_afiliacion->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('fecha_afiliacion') border-red-500 @enderror">
                                    @error('fecha_afiliacion')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                                    <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('estado') border-red-500 @enderror">
                                        <option value="activo" {{ old('estado', $afiliado->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado', $afiliado->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Foto Actual -->
                                @if($afiliado->foto)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Actual</label>
                                    <img src="{{ Storage::url($afiliado->foto) }}" alt="Foto" class="h-32 w-32 object-cover rounded-lg border border-gray-300">
                                </div>
                                @endif

                                <!-- Nueva Foto -->
                                <div class="md:col-span-2">
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">{{ $afiliado->foto ? 'Cambiar Foto' : 'Foto' }} (opcional)</label>
                                    <input type="file" name="foto" id="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('foto') border-red-500 @enderror">
                                    @error('foto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-4 mt-8">
                                <a href="{{ route('afiliados.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    Cancelar
                                </a>
                                <button type="submit" class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                                    Actualizar Afiliado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
