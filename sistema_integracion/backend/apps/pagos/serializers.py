from rest_framework import serializers
from .models import TipoPago, Pago, Egreso
from apps.afiliados.serializers import AfiliadoListSerializer

class TipoPagoSerializer(serializers.ModelSerializer):
    """Serializer for TipoPago model"""
    
    categoria_display = serializers.CharField(source='get_categoria_display', read_only=True)
    
    class Meta:
        model = TipoPago
        fields = ['id', 'nombre', 'categoria', 'categoria_display', 'monto_base', 'descripcion', 'activo']


class PagoSerializer(serializers.ModelSerializer):
    """Serializer for Pago model"""
    
    afiliado_nombre = serializers.CharField(source='afiliado.nombre_completo', read_only=True)
    tipo_pago_nombre = serializers.CharField(source='tipo_pago.nombre', read_only=True)
    total_pago = serializers.ReadOnlyField()
    
    class Meta:
        model = Pago
        fields = [
            'id', 'afiliado', 'afiliado_nombre', 'tipo_pago', 'tipo_pago_nombre',
            'monto', 'fecha_pago', 'mes_correspondiente', 'descripcion',
            'numero_recibo', 'codigo_qr', 'es_mora', 'monto_mora', 'total_pago',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['numero_recibo', 'codigo_qr', 'created_at', 'updated_at']
    
    def create(self, validated_data):
        # Auto-generate numero_recibo
        ultimo_pago = Pago.objects.order_by('-id').first()
        if ultimo_pago:
            ultimo_numero = int(ultimo_pago.numero_recibo.split('-')[1])
            nuevo_numero = ultimo_numero + 1
        else:
            nuevo_numero = 1
        
        validated_data['numero_recibo'] = f"REC-{nuevo_numero:08d}"
        pago = Pago.objects.create(**validated_data)
        pago.codigo_qr = f"PAG-{pago.id:08d}"
        pago.save()
        
        return pago


class PagoDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested objects"""
    
    afiliado = AfiliadoListSerializer(read_only=True)
    tipo_pago = TipoPagoSerializer(read_only=True)
    total_pago = serializers.ReadOnlyField()
    
    class Meta:
        model = Pago
        fields = '__all__'


class EgresoSerializer(serializers.ModelSerializer):
    """Serializer for Egreso model"""
    
    class Meta:
        model = Egreso
        fields = '__all__'
        read_only_fields = ['created_at', 'updated_at']
