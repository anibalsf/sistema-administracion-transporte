from rest_framework import serializers
from .models import Reserva
from apps.afiliados.serializers import AfiliadoListSerializer
from apps.vehiculos.serializers import VehiculoSerializer
from apps.rutas.serializers import RutaSerializer

class ReservaSerializer(serializers.ModelSerializer):
    """Serializer for Reserva model"""
    
    vehiculo_placa = serializers.CharField(source='vehiculo.placa', read_only=True)
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    ruta_nombre = serializers.CharField(source='ruta.nombre_ruta', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Reserva
        fields = [
            'id', 'vehiculo', 'vehiculo_placa', 'afiliado', 'afiliado_nombre',
            'ruta', 'ruta_nombre', 'pasajero_nombre', 'pasajero_telefono',
            'pasajero_ci', 'asiento_numero', 'fecha_viaje', 'monto',
            'estado', 'estado_display', 'observaciones',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']


class ReservaDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested objects"""
    
    vehiculo = VehiculoSerializer(read_only=True)
    afiliado = AfiliadoListSerializer(read_only=True)
    ruta = RutaSerializer(read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Reserva
        fields = '__all__'
