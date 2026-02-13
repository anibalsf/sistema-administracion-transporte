from rest_framework import serializers
from .models import Directorio
from apps.afiliados.serializers import AfiliadoListSerializer

class DirectorioSerializer(serializers.ModelSerializer):
    """Serializer for Directorio model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    cargo_display = serializers.CharField(source='get_cargo_display', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Directorio
        fields = [
            'id', 'afiliado', 'afiliado_nombre', 'cargo', 'cargo_display',
            'gestion_inicio', 'gestion_fin', 'estado', 'estado_display',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']


class DirectorioDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested afiliado data"""
    
    afiliado = AfiliadoListSerializer(read_only=True)
    cargo_display = serializers.CharField(source='get_cargo_display', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Directorio
        fields = '__all__'
