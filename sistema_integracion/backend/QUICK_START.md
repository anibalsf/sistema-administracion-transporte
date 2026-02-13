# Quick Start Script - Sistema Integración Taipiplaya

## 1. Activar entorno virtual e instalar django-filter
.\venv\Scripts\Activate.ps1
pip install django-filter

## 2. Crear base de datos MySQL
# Opción A: Si tienes MySQL CLI en PATH
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sindicato_taipiplaya CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Opción B: Usar MySQL Workbench o phpMyAdmin
# CREATE DATABASE sindicato_taipiplaya CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

## 3. Crear migraciones
python manage.py makemigrations usuarios
python manage.py makemigrations afiliados
python manage.py makemigrations vehiculos
python manage.py makemigrations directorio
python manage.py makemigrations rutas
python manage.py makemigrations hojas_ruta
python manage.py makemigrations pagos
python manage.py makemigrations reservas
python manage.py makemigrations sanciones

## 4. Ejecutar migraciones
python manage.py migrate

## 5. Crear superusuario
python manage.py createsuperuser
# Email: admin@sindicato.com
# Password: (tu password seguro)

## 6. Ejecutar servidor de desarrollo
python manage.py runserver

## 7. Acceder a:
#    - Admin Panel: http://localhost:8000/admin
#    - API Root: http://localhost:8000/api/
#    - JWT Token: http://localhost:8000/api/token/

## 8. Endpoints disponibles:
# /api/afiliados/
# /api/afiliados/activos/
# /api/afiliados/{id}/vehiculos/
# /api/vehiculos/
# /api/vehiculos/disponibles/
# /api/usuarios/
# /api/usuarios/me/
# /api/directorio/
# /api/directorio/vigente/
# /api/rutas/
# /api/rutas/activas/
# /api/hojas-ruta/
# /api/hojas-ruta/hoy/
# /api/hojas-ruta/{id}/generar_pdf/
# /api/hojas-ruta/{id}/enviar_whatsapp/
# /api/agentes-parada/
# /api/agentes-parada/hoy/
# /api/tipos-pago/
# /api/pagos/
# /api/pagos/reporte_mensual/
# /api/pagos/deudores/
# /api/egresos/
# /api/egresos/reporte_mensual/
# /api/reservas/
# /api/reservas/hoy/
# /api/reservas/proximas/
# /api/reservas/asientos_disponibles/
# /api/reservas/{id}/cancelar/
# /api/reuniones/
# /api/asistencias/
# /api/sanciones/
# /api/sanciones/pendientes/
# /api/sanciones/{id}/marcar_pagado/
