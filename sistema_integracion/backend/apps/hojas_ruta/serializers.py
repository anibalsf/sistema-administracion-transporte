from rest_framework import serializers
from .models import HojaRuta, AgenteParada
from apps.afiliados.serializers import AfiliadoListSerializer
from apps.vehiculos.serializers import VehiculoSerializer
from apps.rutas.serializers import RutaSerializer

class AgenteParadaSerializer(serializers.ModelSerializer):
    """Serializer for AgenteParada model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    
    class Meta:
        model = AgenteParada
        fields = ['id', 'afiliado', 'afiliado_nombre', 'fecha_designacion', 'observaciones', 'created_at']
        read_only_fields = ['created_at']


class HojaRutaSerializer(serializers.ModelSerializer):
    """Serializer for HojaRuta model"""
    
    vehiculo_placa = serializers.CharField(source='vehiculo.placa', read_only=True)
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    ruta_nombre = serializers.CharField(source='ruta.nombre_ruta', read_only=True)
    agente_nombre = serializers.CharField(source='agente_parada.afiliado.nombre_completo', read_only=True)
    
    class Meta:
        model = HojaRuta
        fields = [
            'id', 'vehiculo', 'vehiculo_placa', 'afiliado', 'afiliado_nombre',
            'ruta', 'ruta_nombre', 'agente_parada', 'agente_nombre',
            'fecha_emision', 'fecha_salida', 'monto', 'pdf_url', 'codigo_qr',
            'enviado_whatsapp', 'fecha_envio_whatsapp', 'created_at', 'updated_at'
        ]
        read_only_fields = ['pdf_url', 'codigo_qr', 'created_at', 'updated_at']


class HojaRutaDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested objects"""
    
    vehiculo = VehiculoSerializer(read_only=True)
    afiliado = AfiliadoListSerializer(read_only=True)
    ruta = RutaSerializer(read_only=True)
    agente_parada = AgenteParadaSerializer(read_only=True)
    
    class Meta:
        model = HojaRuta
        fields = '__all__'


class HojaRutaCreateSerializer(serializers.ModelSerializer):
    """Serializer for creating HojaRuta"""
    
    class Meta:
        model = HojaRuta
        fields = [
            'vehiculo', 'afiliado', 'ruta', 'agente_parada',
            'fecha_emision', 'fecha_salida', 'monto'
        ]
    
    def create(self, validated_data):
        # Auto-calculate monto from ruta if not provided
        if 'monto' not in validated_data or not validated_data['monto']:
            validated_data['monto'] = validated_data['ruta'].precio
        
        # Generate QR code (simple ID-based for now)
        hoja = HojaRuta.objects.create(**validated_data)
        hoja.codigo_qr = f"HR-{hoja.id:08d}"
        hoja.save()
        
        return hoja
