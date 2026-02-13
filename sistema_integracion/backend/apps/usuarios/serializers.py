from rest_framework import serializers
from .models import Usuario
from apps.afiliados.serializers import AfiliadoListSerializer

class UsuarioSerializer(serializers.ModelSerializer):
    """Serializer for Usuario model"""
    
    nombre_completo = serializers.ReadOnlyField()
    rol_display = serializers.CharField(source='get_rol_display', read_only=True)
    password = serializers.CharField(write_only=True, required=False)
    
    class Meta:
        model = Usuario
        fields = [
            'id', 'email', 'nombre', 'apellido', 'nombre_completo',
            'telefono', 'rol', 'rol_display', 'afiliado', 'is_active',
            'password', 'date_joined', 'last_login'
        ]
        read_only_fields = ['date_joined', 'last_login']
        extra_kwargs = {
            'password': {'write_only': True}
        }
    
    def create(self, validated_data):
        password = validated_data.pop('password', None)
        user = Usuario.objects.create_user(**validated_data)
        if password:
            user.set_password(password)
            user.save()
        return user
    
    def update(self, instance, validated_data):
        password = validated_data.pop('password', None)
        for attr, value in validated_data.items():
            setattr(instance, attr, value)
        if password:
            instance.set_password(password)
        instance.save()
        return instance


class UsuarioDetailSerializer(serializers.ModelSerializer):
    """Detailed serializer with nested afiliado data"""
    
    afiliado = AfiliadoListSerializer(read_only=True)
    nombre_completo = serializers.ReadOnlyField()
    rol_display = serializers.CharField(source='get_rol_display', read_only=True)
    
    class Meta:
        model = Usuario
        fields = [
            'id', 'email', 'nombre', 'apellido', 'nombre_completo',
            'telefono', 'rol', 'rol_display', 'afiliado', 'is_active',
            'date_joined', 'last_login'
        ]


class UsuarioLoginSerializer(serializers.Serializer):
    """Serializer for login"""
    email = serializers.EmailField()
    password = serializers.CharField(write_only=True)
