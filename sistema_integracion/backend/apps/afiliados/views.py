from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from .models import Afiliado
from .serializers import AfiliadoSerializer, AfiliadoListSerializer

class AfiliadoViewSet(viewsets.ModelViewSet):
    """
    ViewSet for Afiliado CRUD operations
    
    list: Get all affiliates
    create: Create new affiliate
    retrieve: Get single affiliate
    update: Update affiliate
    partial_update: Partial update affiliate
    destroy: Delete affiliate (soft delete by setting estado='inactivo')
    """
    
    queryset = Afiliado.objects.all()
    serializer_class = AfiliadoSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['estado', 'fecha_ingreso']
    search_fields = ['nombre', 'apellido', 'cedula', 'telefono']
    ordering_fields = ['apellido', 'fecha_ingreso', 'created_at']
    ordering = ['apellido', 'nombre']
    
    def get_serializer_class(self):
        if self.action == 'list':
            return AfiliadoListSerializer
        return AfiliadoSerializer
    
    def destroy(self, request, *args, **kwargs):
        """Soft delete - change estado to 'pasivo'"""
        instance = self.get_object()
        instance.estado = 'pasivo'
        instance.save()
        return Response(
            {'message': 'Afiliado marcado como pasivo exitosamente'},
            status=status.HTTP_200_OK
        )
    
    @action(detail=False, methods=['get'])
    def activos(self, request):
        """Get only active affiliates"""
        activos = self.queryset.filter(estado='activo')
        serializer = self.get_serializer(activos, many=True)
        return Response(serializer.data)
    
    @action(detail=True, methods=['get'])
    def vehiculos(self, request, pk=None):
        """Get all vehicles of an affiliate"""
        afiliado = self.get_object()
        from apps.vehiculos.serializers import VehiculoSerializer
        vehiculos = afiliado.vehiculos.all()
        serializer = VehiculoSerializer(vehiculos, many=True)
        return Response(serializer.data)
