from rest_framework import serializers
from .models import Afiliado

class AfiliadoSerializer(serializers.ModelSerializer):
    """Serializer for Afiliado model"""
    
    nombre_completo = serializers.ReadOnlyField()
    total_vehiculos = serializers.SerializerMethodField()
    
    class Meta:
        model = Afiliado
        fields = [
            'id', 'nombre', 'apellido', 'nombre_completo', 'cedula', 
            'telefono', 'direccion', 'fecha_ingreso', 'estado', 'foto',
            'total_vehiculos', 'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']
    
    def get_total_vehiculos(self, obj):
        return obj.vehiculos.count()


class AfiliadoListSerializer(serializers.ModelSerializer):
    """Lightweight serializer for list views"""
    
    nombre_completo = serializers.ReadOnlyField()
    
    class Meta:
        model = Afiliado
        fields = ['id', 'nombre_completo', 'cedula', 'telefono', 'estado']
