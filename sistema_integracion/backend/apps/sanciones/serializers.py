from rest_framework import serializers
from .models import Reunion, Asistencia, Sancion
from apps.afiliados.serializers import AfiliadoListSerializer

class ReunionSerializer(serializers.ModelSerializer):
    """Serializer for Reunion model"""
    
    total_afiliados = serializers.SerializerMethodField()
    total_asistencias = serializers.SerializerMethodField()
    
    class Meta:
        model = Reunion
        fields = ['id', 'titulo', 'fecha_reunion', 'lugar', 'descripcion', 
                  'asistencia_obligatoria', 'total_afiliados', 'total_asistencias', 
                  'created_at']
        read_only_fields = ['created_at']
    
    def get_total_afiliados(self, obj):
        from apps.afiliados.models import Afiliado
        return Afiliado.objects.filter(estado='activo').count()
    
    def get_total_asistencias(self, obj):
        return obj.asistencias.count()


class AsistenciaSerializer(serializers.ModelSerializer):
    """Serializer for Asistencia model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    reunion_titulo = serializers.CharField(source='reunion.titulo', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Asistencia
        fields = ['id', 'reunion', 'reunion_titulo', 'afiliado', 'afiliado_nombre',
                  'estado', 'estado_display', 'observaciones', 'created_at']
        read_only_fields = ['created_at']


class SancionSerializer(serializers.ModelSerializer):
    """Serializer for Sancion model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    estado_display = serializers.CharField(source='get_estado_display', read_only=True)
    
    class Meta:
        model = Sancion
        fields = ['id', 'afiliado', 'afiliado_nombre', 'asistencia', 'motivo',
                  'monto', 'fecha_sancion', 'fecha_limite_pago', 'estado', 
                  'estado_display', 'fecha_pago', 'created_at', 'updated_at']
        read_only_fields = ['created_at', 'updated_at']
