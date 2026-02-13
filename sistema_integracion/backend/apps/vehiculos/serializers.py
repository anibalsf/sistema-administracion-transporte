from rest_framework import serializers
from .models import Vehiculo
from apps.afiliados.serializers import AfiliadoListSerializer

class VehiculoSerializer(serializers.ModelSerializer):
    """Serializer for Vehiculo model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    tipo_display = serializers.CharField(source='get_tipo_display', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Vehiculo
        fields = [
            'id', 'placa', 'marca', 'modelo', 'tipo', 'tipo_display',
            'color', 'anio', 'estado', 'estado_display', 'capacidad',
            'afiliado', 'afiliado_nombre', 'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']


class VehiculoDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested afiliado data"""
    
    afiliado = AfiliadoListSerializer(read_only=True)
    tipo_display = serializers.CharField(source='get_tipo_display', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Vehiculo
        fields = '__all__'
