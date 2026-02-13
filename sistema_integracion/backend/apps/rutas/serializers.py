from rest_framework import serializers
from .models import Ruta

class RutaSerializer(serializers.ModelSerializer):
    """Serializer for Ruta model"""
    
    class Meta:
        model = Ruta
        fields = ['id', 'nombre_ruta', 'precio', 'descripcion', 'activa', 'created_at', 'updated_at']
        read_only_fields = ['created_at', 'updated_at']
