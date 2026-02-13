from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from .models import Vehiculo
from .serializers import VehiculoSerializer, VehiculoDetailSerializer

class VehiculoViewSet(viewsets.ModelViewSet):
    """
    ViewSet for Vehiculo CRUD operations
    """
    
    queryset = Vehiculo.objects.select_related('afiliado').all()
    serializer_class = VehiculoSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['tipo', 'estado', 'afiliado']
    search_fields = ['placa', 'marca', 'modelo', 'afiliado__nombre', 'afiliado__apellido']
    ordering_fields = ['placa', 'anio', 'created_at']
    ordering = ['placa']
    
    def get_serializer_class(self):
        if self.action == 'retrieve':
            return VehiculoDetailSerializer
        return VehiculoSerializer
    
    @action(detail=False, methods=['get'])
    def activos(self, request):
        """Get only active vehicles"""
        activos = self.queryset.filter(estado='activo')
        serializer = self.get_serializer(activos, many=True)
        return Response(serializer.data)
    
    @action(detail=False, methods=['get'])
    def disponibles(self, request):
        """Get available vehicles (activos and not in mantenimiento)"""
        disponibles = self.queryset.filter(estado='activo')
        serializer = self.get_serializer(disponibles, many=True)
        return Response(serializer.data)
