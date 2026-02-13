<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Afiliado;
use App\Models\Vehiculo;
use App\Models\Ruta;
use App\Models\HojaRuta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sindicato.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create afiliados
        $afiliado1 = Afiliado::create([
            'ci' => '1234567',
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'fecha_nacimiento' => '1980-05-15',
            'direccion' => 'Av. Principal #123',
            'telefono' => '71234567',
            'email' => 'juan.perez@example.com',
            'fecha_afiliacion' => '2020-01-15',
            'estado' => 'activo',
        ]);

        $afiliado2 = Afiliado::create([
            'ci' => '2345678',
            'nombres' => 'Carlos',
            'apellidos' => 'Cortez',
            'fecha_nacimiento' => '1975-08-20',
            'direccion' => 'Calle Secundaria #456',
            'telefono' => '72345678',
            'email' => 'carlos.cortez@example.com',
            'fecha_afiliacion' => '2019-06-10',
            'estado' => 'activo',
        ]);

        $afiliado3 = Afiliado::create([
            'ci' => '3456789',
            'nombres' => 'María',
            'apellidos' => 'González',
            'fecha_nacimiento' => '1985-03-10',
            'direccion' => 'Av. Libertad #789',
            'telefono' => '73456789',
            'email' => 'maria.gonzalez@example.com',
            'fecha_afiliacion' => '2021-03-20',
            'estado' => 'activo',
        ]);

        // Create vehiculos
        $vehiculo1 = Vehiculo::create([
            'afiliado_id' => $afiliado1->id,
            'placa' => 'ABC-123',
            'marca' => 'Toyota',
            'modelo' => 'Hiace',
            'anio' => 2018,
            'color' => 'Blanco',
            'tipo' => 'minibus',
            'capacidad' => 14,
            'estado' => 'activo',
        ]);

        $vehiculo2 = Vehiculo::create([
            'afiliado_id' => $afiliado2->id,
            'placa' => 'DEF-456',
            'marca' => 'Nissan',
            'modelo' => 'Urvan',
            'anio' => 2019,
            'color' => 'Azul',
            'tipo' => 'minibus',
            'capacidad' => 15,
            'estado' => 'activo',
        ]);

        $vehiculo3 = Vehiculo::create([
            'afiliado_id' => $afiliado3->id,
            'placa' => 'GHI-789',
            'marca' => 'Hyundai',
            'modelo' => 'H1',
            'anio' => 2020,
            'color' => 'Gris',
            'tipo' => 'minibus',
            'capacidad' => 12,
            'estado' => 'activo',
        ]);

        // Create rutas
        $ruta1 = Ruta::create([
            'nombre' => 'La Paz - Caranavi',
            'origen' => 'La Paz',
            'destino' => 'Caranavi',
            'distancia_km' => 150.5,
            'tiempo_estimado' => 180,
            'tarifa' => 25.00,
            'estado' => 'activa',
            'descripcion' => 'Ruta principal a Caranavi',
        ]);

        $ruta2 = Ruta::create([
            'nombre' => 'La Paz - Rincón',
            'origen' => 'La Paz',
            'destino' => 'Rincón',
            'distancia_km' => 120.0,
            'tiempo_estimado' => 150,
            'tarifa' => 20.00,
            'estado' => 'activa',
            'descripcion' => 'Ruta a Rincón',
        ]);

        // Create hojas de ruta
        HojaRuta::create([
            'afiliado_id' => $afiliado1->id,
            'vehiculo_id' => $vehiculo1->id,
            'ruta_id' => $ruta1->id,
            'fecha' => '2024-03-27',
            'hora_salida' => '08:00:00',
            'hora_llegada' => '11:00:00',
            'monto' => 30.00,
            'pasajeros' => 12,
        ]);

        HojaRuta::create([
            'afiliado_id' => $afiliado2->id,
            'vehiculo_id' => $vehiculo2->id,
            'ruta_id' => $ruta2->id,
            'fecha' => '2024-03-01',
            'hora_salida' => '09:00:00',
            'hora_llegada' => '11:30:00',
            'monto' => 25.00,
            'pasajeros' => 10,
        ]);

        HojaRuta::create([
            'afiliado_id' => $afiliado3->id,
            'vehiculo_id' => $vehiculo3->id,
            'ruta_id' => $ruta2->id,
            'fecha' => '2024-03-02',
            'hora_salida' => '07:30:00',
            'hora_llegada' => '10:00:00',
            'monto' => 25.00,
            'pasajeros' => 8,
        ]);

        HojaRuta::create([
            'afiliado_id' => $afiliado1->id,
            'vehiculo_id' => $vehiculo1->id,
            'ruta_id' => $ruta1->id,
            'fecha' => '2024-03-11',
            'hora_salida' => '08:15:00',
            'hora_llegada' => '11:15:00',
            'monto' => 16.00,
            'pasajeros' => 14,
        ]);

        HojaRuta::create([
            'afiliado_id' => $afiliado2->id,
            'vehiculo_id' => $vehiculo2->id,
            'ruta_id' => $ruta2->id,
            'fecha' => '2024-03-01',
            'hora_salida' => '10:00:00',
            'hora_llegada' => '12:30:00',
            'monto' => 15.00,
            'pasajeros' => 9,
        ]);

        HojaRuta::create([
            'afiliado_id' => $afiliado3->id,
            'vehiculo_id' => $vehiculo3->id,
            'ruta_id' => $ruta2->id,
            'fecha' => '2024-04-02',
            'hora_salida' => '06:00:00',
            'hora_llegada' => '08:30:00',
            'monto' => 30.00,
            'pasajeros' => 11,
        ]);
    }
}
